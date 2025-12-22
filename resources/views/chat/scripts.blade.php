<script>
    function chatApp(initialMessages, initialChatId) {
        return {
            sidebarOpen: false,
            input: '{{ $initialPrompt ?? "" }}',
            agentId: '{{ $initialAgent ?? "thinking_ai" }}',
            messages: initialMessages || [],
            chatId: initialChatId || null,
            isThinking: false,
            showLoginModal: false,

            isUserLoggedIn: {{ Auth::check() ? 'true' : 'false' }},

            init() {
                this.scrollToBottom();
                if (this.input && this.messages.length === 0) {
                     this.sendMessage();
                }
                
                // Initialize KaTeX & Highlight.js on load
                this.$nextTick(() => {
                    this.renderMathAndCode();
                });

                // Listen for input area submission
                window.addEventListener('chat-submit', (e) => {
                    this.sendMessage(e.detail.message);
                });

                // Listen for stop generation request
                window.addEventListener('chat-stop', () => {
                   // Implement stop logic if AbortController was available
                   // For now, we can just set isThinking to false to reset UI
                   this.isThinking = false;
                   window.toast('Generation stopped', 'info');
                });
            },

            scrollToBottom() {
                this.$nextTick(() => {
                    const container = document.getElementById('messages-container');
                    if (container) {
                        container.scrollTop = container.scrollHeight;
                    }
                });
            },

            renderMathAndCode() {
                this.$nextTick(() => {
                    const container = document.getElementById('messages-container');
                    if (!container) return;
                    
                    if (window.hljs) {
                        container.querySelectorAll('pre code').forEach(block => window.hljs.highlightElement(block));
                    }
                    if (window.renderMathInElement) {
                        window.renderMathInElement(container, {
                            delimiters: [
                                {left: '$$', right: '$$', display: true},
                                {left: '$', right: '$', display: false},
                                {left: '\\(', right: '\\)', display: false},
                                {left: '\\[', right: '\\]', display: true}
                            ],
                            throwOnError: false
                        });
                    }
                });
            },

            async sendMessage(customContent = null) {
                const textToSend = customContent || this.input;

                if (!textToSend.trim() || this.isThinking) return;

                // Check Guest Limit (Max 3 prompts)
                const userMsgCount = this.messages.filter(m => m.role === 'user').length;
                if (!this.isUserLoggedIn && userMsgCount >= 3) {
                    this.showLoginModal = true;
                    return;
                }

                const userMsg = { id: Date.now(), role: 'user', content: textToSend };
                this.messages.push(userMsg);
                
                const prompt = textToSend; 
                this.input = ''; // Clear parent input state just in case
                this.isThinking = true;
                window.dispatchEvent(new CustomEvent('ai-thinking-start'));
                this.scrollToBottom();
                this.renderMathAndCode();

                // Create AI Placeholder
                const aiMsgId = Date.now() + 1;
                this.messages.push({ id: aiMsgId, role: 'model', content: '' });

                try {
                    // Create Conversation on server ONLY if user is logged in
                    if (!this.chatId && this.isUserLoggedIn) {
                        console.log('Creating new conversation...', {
                            message: prompt,
                            agent_id: this.agentId,
                            messages: this.messages
                        });
                        
                        const createRes = await fetch("{{ route('chat.store') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                message: prompt,
                                agent_id: this.agentId,
                                messages: this.messages 
                            })
                        });
                        
                        console.log('Create response status:', createRes.status);
                        
                        if(createRes.ok) {
                            const createData = await createRes.json();
                            console.log('Conversation created:', createData);
                            this.chatId = createData.id;
                            // Continue with streaming instead of redirecting
                        } else {
                            const errorText = await createRes.text();
                            console.error('Failed to create conversation:', createRes.status, errorText);
                            window.toast('Failed to save conversation', 'error');
                        }
                    } else {
                        console.log('Skipping conversation creation:', {
                            chatId: this.chatId,
                            isUserLoggedIn: this.isUserLoggedIn
                        });
                    }

                    // Start stream
                    const response = await fetch("{{ route('chat.stream') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            message: prompt,
                            agent_id: this.agentId,
                            history: this.messages.slice(0, -2)
                        })
                    });

                    if (!response.ok) throw new Error('Network response was not ok');

                    const reader = response.body.getReader();
                    const decoder = new TextDecoder();
                    let aiContent = '';

                    while (true) {
                        const { done, value } = await reader.read();
                        if (done) break;
                        
                        const chunk = decoder.decode(value);
                        const lines = chunk.split('\n');
                        for (const line of lines) {
                            if (line.startsWith('data: ')) {
                                const data = line.slice(6);
                                if (data === '[DONE]') break;
                                try {
                                    const json = JSON.parse(data);
                                    const content = json.choices[0]?.delta?.content || "";
                                    aiContent += content;
                                    
                                    // Update message content
                                    const msgIndex = this.messages.findIndex(m => m.id === aiMsgId);
                                    if(msgIndex !== -1) {
                                        this.messages[msgIndex].content = aiContent;
                                    }
                                    
                                    this.scrollToBottom();
                                } catch (e) {}
                            }
                        }
                    }

                    // Final render pass for the complete message
                    this.renderMathAndCode();

                    // Save conversation with AI response if user is logged in and has a chatId
                    if (this.chatId && this.isUserLoggedIn && aiContent) {
                        this.updateConversation();
                    }

                } catch (error) {
                    console.error('Error:', error);
                    const msgIndex = this.messages.findIndex(m => m.id === aiMsgId);
                    if(msgIndex !== -1) {
                        this.messages[msgIndex].content = "Error generating response. Please try again.";
                    }
                    window.toast('Error generating response', 'error');
                } finally {
                    this.isThinking = false;
                    window.dispatchEvent(new CustomEvent('ai-thinking-end'));
                }
            },

            async updateConversation() {
                if (!this.chatId) return;
                
                try {
                    const response = await fetch(`{{ route('chat.update', ':id') }}`.replace(':id', this.chatId), {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            messages: this.messages
                        })
                    });
                    
                    if (response.ok) {
                        console.log('Conversation updated successfully');
                    } else {
                        console.error('Failed to update conversation');
                    }
                } catch (error) {
                    console.error('Error updating conversation:', error);
                }
            }
        }
    }
</script>
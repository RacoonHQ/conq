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

            init() {
                this.scrollToBottom();
                if (this.input && this.messages.length === 0) {
                     this.sendMessage();
                }
                
                // Initialize KaTeX & Highlight.js on load
                this.$nextTick(() => {
                    this.renderMathAndCode();
                });
            },

            // Updated to handle math and code highlighting after render
            renderMathAndCode() {
                this.$nextTick(() => {
                    // Render Math
                    renderMathInElement(document.body, {
                        delimiters: [
                            {left: '$$', right: '$$', display: true},
                            {left: '$', right: '$', display: false},
                            {left: '\\(', right: '\\)', display: false},
                            {left: '\\[', right: '\\]', display: true}
                        ],
                        throwOnError: false
                    });
                    
                    // Render Code Highlighting
                    document.querySelectorAll('pre code').forEach((block) => {
                        hljs.highlightElement(block);
                    });
                });
            },

            parseMarkdown(text) {
                // Configure marked to use highlight.js
                // Note: basic marked usage returns HTML string. 
                // We depend on the renderMathAndCode() called in x-effect or after update to apply styling.
                return marked.parse(text);
            },

            scrollToBottom() {
                this.$nextTick(() => {
                    const container = document.getElementById('messages-container');
                    if (container) container.scrollTop = container.scrollHeight;
                });
            },

            async sendMessage() {
                if (!this.input.trim() || this.isThinking) return;

                const userMsg = { id: Date.now(), role: 'user', content: this.input };
                this.messages.push(userMsg);
                
                const prompt = this.input;
                this.input = '';
                this.isThinking = true;
                this.scrollToBottom();
                this.renderMathAndCode();

                // Create AI Placeholder
                const aiMsgId = Date.now() + 1;
                this.messages.push({ id: aiMsgId, role: 'model', content: '' });

                try {
                    // Create Conversation on server if new
                    if (!this.chatId) {
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
                        
                        if(createRes.ok) {
                            const createData = await createRes.json();
                            this.chatId = createData.id;
                            window.history.replaceState({}, '', `/prompt/${this.chatId}`);
                        }
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

                } catch (error) {
                    console.error('Error:', error);
                    const msgIndex = this.messages.findIndex(m => m.id === aiMsgId);
                    if(msgIndex !== -1) {
                        this.messages[msgIndex].content = "Error generating response. Please try again.";
                    }
                    window.toast('Error generating response', 'error');
                } finally {
                    this.isThinking = false;
                }
            }
        }
    }
</script>
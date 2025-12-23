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
                
                // Listen for conversation loading from sidebar
                window.addEventListener('load-conversation', (e) => {
                    this.loadConversation(e.detail.conversationId);
                });
                
                // Listen for new chat creation from sidebar
                window.addEventListener('create-new-chat', () => {
                    this.createNewChat();
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
                            
                            // Emit event for sidebar update with actual message as title
                            window.dispatchEvent(new CustomEvent('conversation-created', {
                                detail: { 
                                    conversation: { 
                                        id: createData.id, 
                                        title: prompt.substring(0, 50) + (prompt.length > 50 ? '...' : '')
                                    } 
                                }
                            }));
                            
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

                    if (response.status === 402) {
                        const errorData = await response.json();
                        if (errorData.redirect) {
                            // Store redirect URL and show custom credits modal
                            window.creditsRedirectUrl = errorData.redirect;
                            showCreditsModal();
                        }
                        return;
                    }

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
                        
                        // Update conversation title in sidebar with the first message
                        window.dispatchEvent(new CustomEvent('conversation-title-updated', {
                            detail: { 
                                conversationId: this.chatId, 
                                title: prompt.substring(0, 50) + (prompt.length > 50 ? '...' : '')
                            }
                        }));
                    }

                    // Emit credit update event
                    window.dispatchEvent(new CustomEvent('credits-updated', {
                        detail: { creditsUsed: 5 }
                    }));

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
            },
            
            async loadConversation(conversationId) {
                try {
                    // Don't show thinking animation for conversation loading
                    // Just clear current state and load new conversation
                    
                    // Fetch conversation data from API
                    const response = await fetch(`/api/conversations/${conversationId}`, {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });
                    
                    if (!response.ok) {
                        throw new Error('Failed to load conversation');
                    }
                    
                    const conversationData = await response.json();
                    
                    // Update chat state with loaded conversation
                    this.chatId = conversationData.id;
                    this.messages = conversationData.messages || [];
                    this.agentId = conversationData.agent_id || 'thinking_ai';
                    
                    // Clear any pending input
                    this.input = '';
                    
                    // Ensure thinking state is false
                    this.isThinking = false;
                    
                    // Scroll to bottom
                    this.scrollToBottom();
                    
                    // Render math and code
                    this.renderMathAndCode();
                    
                } catch (error) {
                    console.error('Error loading conversation:', error);
                    this.isThinking = false;
                    window.toast('Failed to load conversation', 'error');
                    
                    // Fallback to page refresh
                    window.location.href = `/prompt/${conversationId}`;
                }
            },
            
            createNewChat() {
                // Reset chat state for new chat
                this.chatId = null;
                this.messages = [];
                this.agentId = 'thinking_ai';
                this.input = '';
                this.isThinking = false;
                
                // Scroll to top
                this.scrollToBottom();
            }
        }
    }

    // Global function for deleting conversations
    let deleteConversationId = null;
    let deleteConversationTitle = null;

    async function deleteConversation(conversationId, conversationTitle) {
        console.log('Attempting to delete conversation:', conversationId, conversationTitle);
        console.log('Conversation ID type:', typeof conversationId);
        console.log('Conversation ID length:', conversationId ? conversationId.length : 'null');
        
        // Store conversation details
        deleteConversationId = conversationId;
        deleteConversationTitle = conversationTitle;
        
        // Set the title in the modal
        document.getElementById('deleteConversationTitle').textContent = conversationTitle;
        
        // Show the custom modal
        const modal = document.getElementById('deleteModal');
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
        
        // Add Alpine.js data binding
        modal._x_dataStack = [modal._x_dataStack[0], { show: true }];
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.style.display = 'none';
        modal.classList.add('hidden');
        
        // Reset Alpine.js data binding
        modal._x_dataStack = [modal._x_dataStack[0], { show: false }];
        
        // Clear stored data
        deleteConversationId = null;
        deleteConversationTitle = null;
        
        console.log('Delete modal closed');
    }

    async function confirmDelete() {
        if (!deleteConversationId || !deleteConversationTitle) {
            console.error('No conversation data stored for deletion');
            return;
        }

        console.log('Proceeding with deletion of:', deleteConversationId, deleteConversationTitle);
        
        // Store the ID locally before closing modal
        const conversationIdToDelete = deleteConversationId;
        
        // Close modal first
        closeDeleteModal();

        try {
            const deleteUrl = `/prompt/${conversationIdToDelete}`;
            console.log('Delete URL:', deleteUrl);
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            console.log('CSRF Token:', csrfToken ? 'found' : 'not found');
            
            const response = await fetch(deleteUrl, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);

            if (response.ok) {
                const data = await response.json();
                console.log('Response data:', data);
                window.toast(data.message || 'Conversation deleted successfully', 'success');
                
                // Emit event for sidebar update
                window.dispatchEvent(new CustomEvent('conversation-deleted', {
                    detail: { conversationId: conversationIdToDelete }
                }));
                
                // Redirect to chat index if we're currently viewing the deleted conversation
                if (window.location.pathname.includes('/prompt/' + conversationIdToDelete)) {
                    window.location.href = '/prompt';
                } else {
                    // Update sidebar without page reload
                    window.dispatchEvent(new CustomEvent('conversation-updated'));
                }
            } else {
                const errorText = await response.text();
                console.error('Failed to delete conversation:', response.status, errorText);
                window.toast(`Failed to delete conversation: ${response.status}`, 'error');
            }
        } catch (error) {
            console.error('Error deleting conversation:', error);
            window.toast('Error deleting conversation: ' + error.message, 'error');
        }
    }

    // Credits Modal Functions
    function showCreditsModal() {
        const modal = document.getElementById('creditsModal');
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
        
        // Add Alpine.js data binding
        modal._x_dataStack = [modal._x_dataStack[0], { show: true }];
    }

    function closeCreditsModal() {
        const modal = document.getElementById('creditsModal');
        modal.style.display = 'none';
        modal.classList.add('hidden');
        
        // Reset Alpine.js data binding
        modal._x_dataStack = [modal._x_dataStack[0], { show: false }];
        
        // Remove the user message and reset thinking state
        const chatApp = document.querySelector('[x-data="chatApp"]').__x.$data;
        if (chatApp) {
            chatApp.messages.pop();
            chatApp.isThinking = false;
            window.dispatchEvent(new CustomEvent('ai-thinking-end'));
        }
    }

    function confirmCreditsRedirect() {
        if (window.creditsRedirectUrl) {
            window.location.href = window.creditsRedirectUrl;
        }
    }
</script>
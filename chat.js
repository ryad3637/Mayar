document.addEventListener('DOMContentLoaded', (event) => {
    const socket = new WebSocket('ws://localhost:8084');
    const messagesContainer = document.getElementById('chat-messages');
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');

    // Récupérer les variables PHP via des attributs data dans l'élément HTML
    const userId = document.getElementById('chat-container').dataset.userId;
    const userName = document.getElementById('chat-container').dataset.userName;
    const receiverId = document.getElementById('chat-container').dataset.receiverId;
    const conversationId = 1; // Vous pouvez gérer les IDs de conversation comme vous le souhaitez

    socket.addEventListener('open', (event) => {
        console.log('Connected to WebSocket server');
    });

    socket.addEventListener('message', (event) => {
        const messageData = JSON.parse(event.data);
        displayMessage(`${messageData.senderName}: ${messageData.message}`);
    });

    sendButton.addEventListener('click', () => {
        const message = messageInput.value;
        if (message.trim()) {
            const messagePayload = JSON.stringify({
                senderId: userId,
                senderName: userName,
                receiverId: receiverId,
                conversationId: conversationId,
                message: message
            });
            socket.send(messagePayload);
            messageInput.value = '';
            displayMessage(`You: ${message}`);
        }
    });

    function displayMessage(message) {
        const messageElement = document.createElement('div');
        messageElement.textContent = message;
        messagesContainer.appendChild(messageElement);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
});

function sendMessage() {
    const userInput = document.getElementById('user-input').value;
    if (userInput.trim() !== '') {
        const userMessage = document.createElement('div');
        userMessage.className = 'message user';
        userMessage.textContent = userInput;
        document.getElementById('chat-messages').appendChild(userMessage);

        document.getElementById('user-input').value = '';

        setTimeout(() => {
            const companyMessage = document.createElement('div');
            companyMessage.className = 'message company';
            const companyImg = document.createElement('img');
            companyImg.src = '客服.png';
            companyImg.alt = 'Company';
            companyMessage.appendChild(companyImg);
            companyMessage.appendChild(document.createTextNode('感謝您的來信！正在轉接客服，請耐心等待專員為您解答...'));
            document.getElementById('chat-messages').appendChild(companyMessage);
        }, 1000);
    }
}
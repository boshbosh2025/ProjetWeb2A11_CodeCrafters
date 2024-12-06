<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduLivre ChatBot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css" />
    <link rel="icon" href="logo.png" />
    <style>
        body {
            font-family: 'Karla', sans-serif;
            background-color: #f9f9f9;
        }

        .chat-container {
            max-width: 700px;
            margin: 20px auto;
        }

        .chat-header {
            background-color: #6c5ce7;
            color: white;
            padding: 10px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }

        .chat-box {
            height: 400px;
            overflow-y: auto;
            background-color: #dfe6e9;
            padding: 15px;
            border: 1px solid #ccc;
            border-top: none;
            margin-bottom: 10px;
        }

        .chat-message {
            margin-bottom: 15px;
        }

        .chat-message.user {
            text-align: right;
        }

        .chat-message.bot {
            text-align: left;
        }

        .chat-footer {
            display: flex;
            gap: 10px;
            padding: 10px;
            background-color: #f1f1f1;
            border-top: 1px solid #ccc;
        }

        .chat-footer textarea {
            flex-grow: 1;
        }

        .chat-footer button {
            background-color: #6c5ce7;
            border-color: #6c5ce7;
        }

        .btn-custom {
            background-color: #0984e3;
            border-color: #0984e3;
        }

        .modal-header {
            background-color: #6c5ce7;
            color: white;
        }

        .modal-body {
            text-align: center;
        }

        /* Button for Back to Forum in the Modal */
        .back-to-forum-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #0984e3;
            color: white;
            border: none;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-to-forum-btn:hover {
            background-color: #74b9ff;
        }
    </style>
</head>

<body>
    <div class="chat-container">
        <div class="chat-header">
            <h2>EduLivre ChatBot</h2>
        </div>
        <div class="chat-box" id="chatBox">
            <!-- Messages will dynamically populate here -->
        </div>
        <div class="chat-footer">
            <textarea id="userInput" class="form-control" rows="1" placeholder="Type your message..."></textarea>
            <button id="sendBtn" class="btn btn-primary">Send</button>
        </div>
        <div class="chat-footer">
            <button id="helpBtn" class="btn btn-custom">Help</button>
            <button id="commandsBtn" class="btn btn-custom">Commands</button>
        </div>
    </div>

    <!-- Modal for Confirm Action -->
    <div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="actionModalLabel">ChatBot Action</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="modalMessage">Are you sure you want to perform this action?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmActionBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Button to go back to the forum -->
    <button class="back-to-forum-btn" onclick="window.location.href='../View/index.php';">Back to Forum!</button>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chatBox = document.getElementById('chatBox');
            const userInput = document.getElementById('userInput');
            const sendBtn = document.getElementById('sendBtn');
            const helpBtn = document.getElementById('helpBtn');
            const commandsBtn = document.getElementById('commandsBtn');
            const actionModal = new bootstrap.Modal(document.getElementById('actionModal'));
            const modalMessage = document.getElementById('modalMessage');
            const confirmActionBtn = document.getElementById('confirmActionBtn');

            const responses = {
                hello: "Hello! I'm EduLivre's ChatBot, here to assist you with your studies. How can I help you today?",
                bye: "Goodbye! Study hard, and feel free to reach out anytime.",
                help: "I can assist you with study tips, exam help, common questions, and more. Ask me something!",
                commands: "Here are some commands I understand:\n- 'hello' : Greet me.\n- 'bye' : Say goodbye.\n- 'study tips' : Get study tips.\n- 'math help' : Get help with math.\n- 'science help' : Ask for science resources.\n- 'exam tips' : Get exam preparation tips.\n- 'cs help' : Get computer science advice.\n- 'web development help' : Ask for web development guidance.",
                "study tips": "Here are some study tips: 1. Break your study time into short intervals (e.g., 25-30 minutes).\n2. Review your material regularly.\n3. Take short breaks to stay focused.\n4. Stay organized and keep track of deadlines.",
                "math help": "For math problems, start by understanding the concepts. Break problems down into smaller steps, and practice regularly. You can also use online resources like Khan Academy or Wolfram Alpha for extra help.",
                "science help": "In science, it's important to understand the basic concepts first, such as the scientific method and fundamental laws. Use visuals like diagrams and models to make concepts clearer. Don't hesitate to use online resources like Khan Academy or YouTube for more explanations.",
                "exam tips": "Here are some exam tips: 1. Review the syllabus thoroughly. 2. Practice past papers to understand question patterns. 3. Focus on areas where you struggle the most. 4. Manage your time effectively during the exam.",
                "history": "History is fascinating! Whether you're studying ancient civilizations or modern events, try connecting historical facts with real-life applications. Remember, history helps you understand the world today!",
                "languages": "Learning languages can be fun and rewarding! Practice consistently, learn vocabulary every day, and immerse yourself in the language by reading, writing, or speaking with native speakers.",
                "cs help": "Computer Science is all about solving problems with algorithms, data structures, and programming. Focus on learning the basics, like programming languages (Python, Java, C++), and understanding concepts like algorithms, databases, and operating systems.",
                "web development help": "Web development involves creating websites. You should start by learning HTML, CSS, and JavaScript for frontend development. For backend, learn languages like Node.js, Python, or PHP. Frameworks like React or Django will also help you build modern web apps.",
                "default": "I'm not sure how to respond to that. Please try asking something related to study tips, math, science, history, languages, computer science, or web development."
            };

            function addMessage(content, type) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `chat-message ${type}`;
                messageDiv.textContent = content;
                chatBox.appendChild(messageDiv);
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            function handleUserMessage() {
                const message = userInput.value.trim();
                if (message) {
                    addMessage(message, 'user');
                    userInput.value = '';
                    setTimeout(() => handleBotResponse(message.toLowerCase()), 500);
                }
            }

            function handleBotResponse(userMessage) {
                const response = responses[userMessage] || responses.default;
                addMessage(response, 'bot');
            }

            sendBtn.addEventListener('click', handleUserMessage);

            userInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    handleUserMessage();
                }
            });

            helpBtn.addEventListener('click', function () {
                addMessage(responses.help, 'bot');
            });

            commandsBtn.addEventListener('click', function () {
                addMessage(responses.commands, 'bot');
            });

            confirmActionBtn.addEventListener('click', function () {
                addMessage("Action Confirmed!", 'bot');
                actionModal.hide();
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

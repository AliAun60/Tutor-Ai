AI Tutor

An interactive web-based tutoring application that simulates a conversational AI assistant for students.
Built with HTML, CSS, JavaScript (AJAX/jQuery) on the frontend and a PHP backend with database integration.

✨ Features

Dynamic Chat Interface: Students can ask questions and receive responses in real time.

Level-Based Learning: Dropdown menu allows selecting a learning level (e.g., beginner, intermediate) before chatting.

Asynchronous Communication: Uses AJAX to fetch levels and handle chat interactions without refreshing the page.

Backend Integration: PHP handles requests (final.php, final.class.php) and connects with the database to process inputs and return outputs.

Bootstrap UI: Clean, responsive interface with styled components and navigation.

🛠️ Tech Stack

Frontend: HTML5, CSS3, Bootstrap, JavaScript, jQuery

Backend: PHP (REST-style endpoints)

Database: MySQL (for levels and conversation context)

🚀 Getting Started
Prerequisites

PHP installed (e.g., XAMPP, WAMP, or LAMP stack)

MySQL database with required tables for levels and chat history

Web browser (Chrome, Firefox, etc.)

Setup

Clone this repo:

git clone https://github.com/AliAun60/ai-tutor.git
cd ai-tutor


Place project files in your server’s root directory (e.g., htdocs/ for XAMPP).

Import the provided database schema (if available) into MySQL.

Update final.php and final.class.php with your DB credentials.

Start your Apache & MySQL server.

Open aitutor.html in your browser:

http://localhost/ai-tutor/aitutor.html

📂 Project Structure
.
├── aitutor.html        # Main chat interface
├── aiTutor.js          # Frontend logic for dropdown + chat
├── final.php           # Backend PHP handler (API endpoints)
├── final.class.php     # Backend PHP class (DB logic)
├── css/style.css       # Custom styles (linked in HTML)
└── README.md

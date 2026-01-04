# Programnas

Programnas is a **Stack Overflow–like Question & Answer platform** built using **pure PHP**, without any heavy frameworks.
The project focuses on simplicity, learning, and full control over the codebase.

---

## 🌐 Overview

* Q&A platform for programming topics
* Similar concept to Stack Overflow
* Built with **pure PHP**
* Lightweight and easy to deploy
* Suitable for learning, customization, and small communities

---

## 🚀 Features

* Ask programming questions
* View and browse questions
* Post answers
* Simple page-based architecture
* Fast and minimal setup

---

## 🛠 Tech Stack

* **Backend:** Pure PHP
* **Frontend:** HTML, CSS, JavaScript
* **Database:** MySQL / MariaDB
* **Server:** Apache or Nginx
* **No frameworks used**

---

## 📂 Project Structure

```
programnas/
├── assets/            # CSS, JavaScript, images
├── includes/          # Database connection, helpers, shared logic
├── pages/             # Page logic (questions, answers, etc.)
├── index.php          # Homepage / questions list
├── ask.php            # Ask a question
├── question.php       # Single question page
├── .htaccess
└── README.md
```

*(Exact file names may vary depending on implementation.)*

---

## ⚙️ Requirements

* PHP 7.4+ (PHP 8.x recommended)
* MySQL or MariaDB
* Apache or Nginx
* `.htaccess` enabled (for Apache)

---

## 🧑‍💻 Installation & Setup

1. Clone the repository

   ```
   git clone https://github.com/mohammedmirzada/programnas.git
   ```

2. Move the project into your web server directory

3. Create a MySQL database

4. Update database credentials inside the PHP configuration file

5. Import the database structure (if an SQL file exists)

6. Open the project in your browser

---

## ▶️ Run Locally (Optional)

Using PHP built-in server:

```
php -S localhost:8000
```

Then open:

```
http://localhost:8000
```

---

## 🔧 Configuration

* Database credentials are stored in PHP files
* Update:

  * Database host
  * Database name
  * Username
  * Password

⚠️ Do not commit real credentials to public repositories.

---

## 🔐 Security Notes

* Sanitize all user input
* Use prepared statements for database queries
* Protect against XSS and SQL injection
* Use HTTPS in production

---

## 📈 Future Improvements

* User authentication and profiles
* Voting system (upvotes / downvotes)
* Tags and categories
* Search functionality
* Admin moderation panel

---

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Open a Pull Request

---

## 📄 License

This project is licensed under the **MIT License**.
See the `LICENSE` file for details.

---

## 👤 Author

**Mohammed Dmirzada**
GitHub: [https://github.com/mohammedmirzada](https://github.com/mohammedmirzada)

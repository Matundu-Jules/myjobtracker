# MyJobTracker

A lightweight and secure web application to track job applications, built with vanilla PHP and MySQL.

## ✅ Current Progress

- Project structure set up using a clean, maintainable directory architecture
- `.env` configured for secure handling of sensitive database credentials
- Remote MySQL database hosted on Hostinger is fully functional
- `install.php` creates the `candidatures` table with updated column names in English
- A frontend form (`views/form.php`) designed for submitting job applications
- CSS styling applied through `public/assets/css/style.css`
- A secure submission handler (`src/handlers/store_job_application.php`) processes form data
- Temporary debug output confirms correct insertions into the remote database
- Form data is submitted via an exposed endpoint (`public/post_application.php`)

## 📁 Directory Structure

```
myjobtracker/
├── ai/                            # Placeholder for future AI features
├── public/                        # Public web root
│   ├── post_application.php       # Front controller for form submissions
│   └── assets/css/style.css       # Application stylesheet
├── src/
│   ├── core/database.php          # PDO DB connection (loads from .env)
│   └── handlers/store_job_application.php  # Handles POST form data
├── templates/                     # Future use for UI components
├── uploads/                       # Placeholder for document storage
├── vendor/                        # Composer packages (planned)
├── views/
│   └── form.php                   # Job application submission form
├── .env                           # Environment variables (not committed)
├── .gitignore                     # Ignore vendor, .env, etc.
├── composer.json / lock          # For future PHP dependencies
├── install.php                    # Table creation script
└── README.md                      # Project documentation
```

## 🛠️ How to Run Locally

```bash
php -S localhost:8000 -t public
```

Visit the form at:
[http://localhost:8000/views/form.php](http://localhost:8000/views/form.php)

## 🔒 Environment Configuration

Your `.env` file should look like this:

```
DB_HOST=your_host
DB_NAME=your_database_name
DB_USER=your_username
DB_PASS=your_password
```

## 🚀 Next Steps

- Clean up temporary debug output in the handler
- Add user-facing feedback after form submission
- Display list of job applications (`views/list.php` or similar)
- Implement edit and delete functionalities
- Add tags/filters for organizing applications
- Add import/export (CSV or JSON)
- Later: integrate local AI features to suggest or generate content

## 📌 Commit Name Suggestion

```bash
git commit -m "🎯 Initial working version: form submission, DB storage, structure in place"
```

---

Ready for the next stage! 🔧

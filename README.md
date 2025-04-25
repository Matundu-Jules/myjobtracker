# MyJobTracker

A lightweight and secure web application to track job applications, built with vanilla PHP and MySQL.

## ✅ Current Progress

- Clean, maintainable MVC-like structure (public/, views/, src/, handlers/, etc.)
- `.env` configured for secure database credentials handling
- Remote MySQL database hosted on Hostinger is fully functional
- `install.php` creates the `candidatures` table with English column names
- Frontend form (`views/form.php`) for submitting job applications
- CSS styling applied via `public/assets/css/style.css`
- Submission handler (`src/handlers/store_job_application.php`) securely processes data
- Data submitted through `public/post_application.php`
- Dashboard implemented to display all job applications in a responsive table
- Inline editing enabled on all fields (title, company, location, status, link, dates)
- Input validation on dates (no date inconsistency allowed)
- Dynamic feedback via styled toast notifications (success or error)
- URLs remain clickable and editable with ellipsis styling
- JavaScript logic extracted into `public/assets/js/dashboard.js`

## 📁 Directory Structure

```
myjobtracker/
├── ai/                            # Placeholder for future AI features
├── public/                        # Public web root
│   ├── post_application.php       # Front controller for form submissions
│   ├── delete_application.php     # Proxy to delete handler
│   ├── dashboard.php              # Main dashboard interface
│   ├── assets/
│   │   ├── css/style.css          # Application stylesheet
│   │   └── js/dashboard.js        # JS logic for search/sort/editing
├── src/
│   ├── core/
│   │   ├── config.php
│   │   ├── database.php           # PDO DB connection from .env
│   │   └── env_loader.php
│   └── handlers/
│       ├── store_job_application.php   # Insert handler
│       ├── delete_job_application.php  # Delete handler
│       └── update_job_application.php  # Inline edit handler (JSON)
├── templates/                     # Shared UI components (header/footer)
├── uploads/                       # Placeholder for document storage
├── vendor/                        # Composer packages (planned)
├── views/
│   ├── form.php                   # Job application submission form
│   └── dashboard.php              # Dashboard view (included in public/)
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
[http://localhost:8000/index.php](http://localhost:8000/index.php)

Visit the dashboard at:
[http://localhost:8000/dashboard.php](http://localhost:8000/dashboard.php)

## 🔒 Environment Configuration

Your `.env` file should look like this:

```
DB_HOST=your_host
DB_NAME=your_database_name
DB_USER=your_username
DB_PASS=your_password
```

## 🚀 Next Steps

- Ajout de filtres par statut / entreprise
- Export des candidatures (CSV, JSON...)
- Badges colorés ou visuels sur les statuts
- Intégration IA locale (analyse d’offres, suggestion de réponses...)
- Ajout de pièces jointes (CV, lettre de motivation)
- Statistiques : nombre de candidatures, taux de retour, etc.

## 📌 Commit Name Suggestion

```bash
git commit -m "feat: inline editing complet avec validation, feedback visuel et toasts"
```

---

Ready for the next stage! 🔧

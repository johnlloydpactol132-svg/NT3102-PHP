# Fantasy Journey — PHP Include Laboratory

Converted from the supplied **Activity 3 NT 3.zip** project. Preserves the Fantasy Journey landing-page design and the login/register look.

## Folder structure

- `index.php` — main page composed using PHP `include` statements only.
- `includes/head.php` — HTML document head and stylesheet.
- `includes/navigation.php` — navigation links.
- `includes/header.php` — hero header, includes navigation.
- `includes/content.php` — About, Features, and CTA sections.
- `includes/footer.php` — footer and closing tags.
- `includes/auth.php` — PHP validation regex and account helpers.
- `login.php`, `register.php` — PHP forms with server-side validation.
- `assets/` — original page CSS styles.
- `data/users.json` — simple file storage for lab/demo accounts (passwords hashed).

## Run with XAMPP

1. Copy `Fantasy_Journey_PHP_Lab` into `C:\xampp\htdocs\`.
2. Start **Apache** in the XAMPP Control Panel.
3. Visit `http://localhost/Fantasy_Journey_PHP_Lab/index.php`.
4. Open Register, enter a valid name, email and password (at least 8 characters including a letter and number), and submit.
5. Open Login and sign in with the same credentials. Verify incorrect input shows PHP validation errors.
6. Verify Home, About, Features, Login, Register links work.

## Submission

Upload this folder to GitHub. Add screenshots of (1) index.php and the include files, (2) the rendered home page, (3) the registration page and success result, and (4) the login page and validation output in a `screenshots/` directory. Screenshots must be captured from your running local server; none are fabricated here.

**Note:** JSON storage is for classroom demonstration only. A real website should use a database, rate limiting, CSRF protection and stronger session management. Avoid uploading real account information to GitHub; reset `data/users.json` to `[]` before committing.

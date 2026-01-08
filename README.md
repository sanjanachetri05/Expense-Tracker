#📊 Expense Tracker

Simple PHP + MySQL expense tracker (Add / View / Delete) with a Chart.js breakdown.

##📂 Project files
- `index.php` — main UI (form, chart, recent transactions)
- `index.html` — original HTML copy (optional)
- `add_expense.php` — handles POST to add a new expense
- `delete_expense.php` — handles POST to delete an expense (uses prepared statements)
- `get_data.php` — returns JSON totals per category for the chart
- `db.php` — MySQL connection

## Requirements
- Windows with WAMP (Apache + PHP + MySQL) or equivalent LAMP stack
- PHP 7.4+ (tested with PHP in WAMP)

## Database setup
Run the following SQL in phpMyAdmin or `mysql` to create the database and table:

```sql
CREATE DATABASE IF NOT EXISTS expense_tracker;
USE expense_tracker;

CREATE TABLE IF NOT EXISTS expenses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  category ENUM('Food', 'Travel', 'Bills', 'Entertainment', 'Other'),
  date_added DATE NOT NULL
);
```

## Installation / Run
1. Place this folder in your web server document root (e.g. `c:\wamp64\www\expense_tracker`).
2. Start WAMP (Apache + MySQL).
3. Create the database/table using the SQL above.
4. Open in your browser: `http://localhost/expense_tracker/index.php`.

## Usage
- Use the form on the left to add a new expense.
- The chart updates based on `get_data.php` which aggregates `amount` by `category`.
- Recent transactions show the latest 5 entries; click **Delete** (confirmation asked) to remove a row.

## Notes & Security
- `delete_expense.php` uses a prepared statement to safely delete by `id`.
- `add_expense.php` currently inserts values directly into SQL (string concatenation). This is vulnerable to SQL injection — migrate it to use prepared statements with bound parameters.
- Consider adding CSRF protection for form actions and escaping HTML output where appropriate.

## Troubleshooting
- If `php` is not found in terminal, use the WAMP PHP executable directly, e.g.:

```powershell
C:\wamp64\bin\php\php8.3.14\php.exe -l "c:\wamp64\www\expense_tracker\add_expense.php"
```

- If chart is blank, visit `get_data.php` directly in browser to check JSON output.

## Next steps (optional)
- Harden `add_expense.php` with prepared statements (I can implement this).
- Add flash messages or UI feedback after add/delete.
- Remove `index.html` to avoid duplicate files.

---
Created to help run and maintain the Expense Tracker locally.

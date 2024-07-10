# NeuroRepository
# Neuromodulation Form Application

This application allows patients to fill in a form and calculates a total score based on their responses. Admins can view, edit, and delete completed forms.

## Technologies Used

- PHP (Latest version, NO FRAMEWORK)
- jQuery
- Bootstrap
- MSSQL (Express version can be used)
- GIT
- IIS

## Setup Instructions

1. Clone the repository:
    ```bash
    git clone https://github.com/YOUR_GITHUB_USERNAME/neuromodulation-form.git
    ```

2. Set up the database:
    - Open SQL Server Management Studio (SSMS).
    - Execute the scripts in the `Database` folder to create the database and stored procedures.

3. Configure the application:
    - Update the `config.php` file with your database connection details:
        ```php
        <?php
        $serverName = "YOUR_SERVER_NAME";
        $database = "Neuromodulation";
        $username = "YOUR_DB_USERNAME";
        $password = "YOUR_DB_PASSWORD";
        ?>
        ```

4. Set up IIS:
    - Copy the contents of the repository to the web root directory (e.g., `C:\inetpub\wwwroot\neuromodulation-form`).
    - Ensure that IIS has read/write permissions to the web root directory.
    - Ensure the SQLSRV and PDO_SQLSRV extensions are enabled in `php.ini`.

5. Access the application:
    - Open a web browser and navigate to `http://localhost/neuromodulation-form`.

## Usage

- **Patient Form:** Fill in the patient details and the Brief Pain Inventory (BPI) questions. The total score will be calculated automatically.
- **Admin View:** Access the admin view to see all submitted forms. You can view, edit, or delete any form.

## Decisions Made

- Used stored procedures for all CRUD operations to ensure data integrity and security.
- Used Bootstrap for a responsive and user-friendly design.
- Used jQuery for dynamic form updates (e.g., auto-calculating age and total score).

## Contact

For any questions or issues, please contact Anthony Brady at anthony.brady1@nhs.net.


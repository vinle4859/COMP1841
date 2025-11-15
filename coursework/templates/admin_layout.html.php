<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?=$title?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/COMP1841/coursework/templates/css/questions.css" rel="stylesheet">
    <link href="/COMP1841/coursework/templates/css/admin.css" rel="stylesheet">
    </head>
    <body>
        <header id="admin">
            <h1>University of Greenwich Student Forum - Admin Area</h1>
        </header>

        <div class="admin-container">
            <nav>
                <ul>
                    <li><a href="questions.php">Question List</a></li>
                    <li><a href="messages.php">Inbox (Messages)</a></li>
                    <li><a href="users.php">Users</a></li>
                    <li><a href="modules.php">Modules</a></li>
                    <li><a href="addquestion.php">Add question</a></li>
                    <li><a href="../index.php">Public Site</a></li>
                </ul>
            </nav>

            <main>
                <?=$output?>
            </main>
        </div>

        <footer>
            &copy; IJDB2023
        </footer>

        <script>
        document.addEventListener('DOMContentLoaded', function(){
            // Confirm deletes for forms with class 'confirm-delete'
            document.querySelectorAll('form.confirm-delete').forEach(function(form){
                form.addEventListener('submit', function(e){
                    if (!confirm('Are you sure you want to delete this item?')) {
                        e.preventDefault();
                    }
                });
            });

            // Simple HTML5-driven client-side validation for forms with .needs-validation
            document.querySelectorAll('form.needs-validation').forEach(function(form){
                form.addEventListener('submit', function(e){
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                        alert('Please complete the required fields before submitting the form.');
                    }
                });
            });
        });
        </script>
    </body>
</html>

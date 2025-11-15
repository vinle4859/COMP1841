<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?=$title?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/COMP1841/coursework/templates/css/questions.css" rel="stylesheet">
    </head>
    <body>
        <header><h1>Internet question Database</h1></header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="questions.php">Question List</a></li>
                <li><a href="addquestion.php">Add question</a></li>
                <li><a href="contact.php">Contact us</a></li>
                <li><a href="admin/questions.php">Admin</a></li>
            </ul>
        </nav>
        <main>
            <?=$output?>
        </main>
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

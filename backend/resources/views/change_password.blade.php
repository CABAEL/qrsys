<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Verification</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #343a40;
            color: #fff;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding-top: 100px;
        }

        .card {
            background-color: #4e5459;
            border: none;
        }

        .form-control {
            background-color: #60666d;
            color: #fff;
            border-color: transparent;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            float: right;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title text-center">Change password</h2>
                <form method="POST" id="passwordForm">
                    @csrf
                    <div class="form-group">
                        <label for="password">Old password:</label>
                        <input type="password" class="form-control" id="oldpassword" name="oldpassword" autocomplete="off" required>
                        <label for="repassword">Re-type password:</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" autocomplete="off" required>
                        <label for="newpassword">New password:</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" autocomplete="off" required>
                    </div>
                    <div class="clearfix">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('passwordForm');
        form.addEventListener('submit', async (event) => {
            event.preventDefault(); // Prevent default form submission
            
            
            const formData = new FormData(form);

            
            try {
                var changePassUrl = "{{url_host('changePass')}}";

                const response = await fetch(changePassUrl, {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    const jsonResponse = await response.json();
                        if (jsonResponse.success) {
                            // Password changed successfully, display success message
                            alert(jsonResponse.message);
                        } else {
                            // Display error message from server
                            alert(jsonResponse.message);
                            window.close();
                        }
                } else {
                    // Handle errors or validation issues
                    console.error('Password change failed');
                }
            } catch (error) {
                console.error('An error occurred:', error);
            }
        });
    });
</script>
</body>

</html>

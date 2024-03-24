<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error: Access Denied</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e1dcaa;
            text-align: center;
            padding: 50px;
        }

        .error-container {
            background-color: #b4be96;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 0 auto;
        }

        .error-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .error-message {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .go-back-button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }

        .go-back-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <img src="wwwroot/img/restriction.png" alt="Access Denied" class="error-image">
        <h1>Oops...</h1>
        <p class="error-message">You don't have access to this page.</p>
        <a href="#" class="go-back-button" onclick="history.go(-1); return false;">Go Back</a>
    </div>
</body>
</html>

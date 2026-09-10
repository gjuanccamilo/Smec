
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contáctenos</title>


    <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,500;0,600;1,400&display=swap');

    :root {
        --color-primary: #D45B7A;
        --color-dark: #0B0B0C;
        --color-text: #1C1C1C;
        --color-bg-card: #F8F8F9;
        --color-white: #FFFFFF;
        --font-heading: 'Playfair Display', 'Didot', serif;
        --font-body: 'Montserrat', 'Helvetica Neue', sans-serif;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        min-height: 100vh;
        font-family: var(--font-body);
        background-color: var(--color-bg-card);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    center {
        background-color: var(--color-white);
        padding: 40px 30px;
        border-radius: 12px;
        border: 1px solid rgba(212, 91, 122, 0.15);
        box-shadow: 0 8px 25px rgba(11, 11, 12, 0.05);
        max-width: 450px;
        width: 100%;
    }

    h1 {
        font-family: var(--font-heading);
        color: var(--color-dark);
        font-size: 1.5rem;
        letter-spacing: 1.5px;
        margin-bottom: 25px;
    }

    input[type="button"] {
        padding: 10px 25px;
        background-color: var(--color-primary);
        color: var(--color-white);
        border: none;
        cursor: pointer;
        border-radius: 20px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 600;
        font-family: var(--font-body);
        transition: all 0.3s ease;
    }

    input[type="button"]:hover {
        background-color: var(--color-dark);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
</style>
</head>
<body>
<script>
    alert("Email enviado con éxito");
</script>
<center> <h1> GRACIAS POR CONTACTARNOS </h1>
<a href='contactenos2.php'> <input type='button' value='Volver'></a>
</center>
</body>
</html>



<!DOCTYPE html>
<html>
<head>
    <title>Tourism Portal</title>
    <!-- Add your CSS stylesheets and other meta tags here -->
</head>
<body>
    <header>
        <!-- Add your header content here -->
    </header>

    <main>
        <h1>Welcome to our Tourism Portal</h1>
        <h2>Popular Tourist Attractions</h2>

        <?php
        // Fetch and display the tourist attractions from your database or any other data source
        $attractions = [
            ['name' => 'Attraction 1', 'description' => 'Description of Attraction 1'],
            ['name' => 'Attraction 2', 'description' => 'Description of Attraction 2'],
            ['name' => 'Attraction 3', 'description' => 'Description of Attraction 3'],
            // Add more attractions as needed
        ];

        foreach ($attractions as $attraction) {
            echo '<div>';
            echo '<h3>' . $attraction['name'] . '</h3>';
            echo '<p>' . $attraction['description'] . '</p>';
            echo '</div>';
        }
        ?>

    </main>

    <footer>
        <!-- Add your footer content here -->
    </footer>
</body>
</html>
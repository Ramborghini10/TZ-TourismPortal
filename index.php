<?php
include('includes/db.php');

// Fetch tourist attractions from the database
$query = "SELECT name, description, image FROM destinations";
$result = $conn->query($query);

$attractions = [];
if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $attractions[] = $row;
        }
    }
} else {
    echo "Error: " . $conn->error;
}
?>


    <style>
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        #video-background {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1000;
            overflow: hidden;
        }
        .navbar {
            background: rgba(0, 0, 0, 0.7);
        }
        .carousel-caption {
            background: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
        }
        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 30vh;
        }
        .search-input {
            width: 50%;
            padding: 20px;
            font-size: 1.5rem;
            border-radius: 50px;
            border: 1px solid #ccc;
        }
        .attractions-carousel {
            margin-top: 20px;
        }
        .carousel-item .card {
            margin: 15px;
            cursor: pointer;
        }
        .carousel-item .card img {
            height: 400px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <video autoplay loop muted id="video-background">
        <source src="assets/images/bg.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

   <?php include('includes/header.php'); ?>
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/images/slide1.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Explore the World</h5>
                    <p>Discover new places and experiences</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/images/slide2.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Adventure Awaits</h5>
                    <p>Find your next adventure with us</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/images/slide3.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Unforgettable Memories</h5>
                    <p>Create memories that last a lifetime</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="search-container">
        <input type="text" class="search-input" id="search-input" placeholder="Search for destinations, activities, and more...">
    </div>

    <div id="attractionsCarousel" class="carousel slide attractions-carousel" data-bs-ride="carousel">
        <div class="carousel-inner" id="attractions-container">
            <?php if (empty($attractions)): ?>
                <div class="carousel-item active">
                    <div class="d-flex justify-content-center">
                        <div class="card" style="width: 45%;">
                            <img src="assets/images/no_image_available.png" class="card-img-top" alt="No attractions available">
                            <div class="card-body">
                                <h5 class="card-title">No attractions available</h5>
                                <p class="card-text">Please check back later</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach (array_chunk($attractions, 2) as $index => $attractionChunk): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="d-flex justify-content-center">
                            <?php foreach ($attractionChunk as $attraction): ?>
                                <div class="card" style="width: 45%;" onclick="location.href='destination_details.php?name=<?= urlencode($attraction['name']) ?>'">
                                    <img src="assets/images/<?= htmlspecialchars($attraction['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($attraction['name']) ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($attraction['name']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($attraction['description']) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#attractionsCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#attractionsCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const myCarousel = document.querySelector('#attractionsCarousel');
        const carousel = new bootstrap.Carousel(myCarousel, {
            interval: 2000,
            ride: 'carousel'
        });

        $(document).ready(function(){
            $('#search-input').on('input', function() {
                let query = $(this).val();
                $.ajax({
                    url: 'search.php',
                    method: 'GET',
                    data: { query: query },
                    success: function(response) {
                        $('#attractions-container').html(response);
                    }
                });
            });
        });
    </script>
</body>
</html>

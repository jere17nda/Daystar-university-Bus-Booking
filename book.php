<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Booking Page</title>
    <style>
        /* Styles go here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f4f4f4;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .search-form {
            margin-bottom: 20px;
        }

        .search-form label {
            display: block;
            margin-bottom: 5px;
        }

        .search-form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
        }

        .search-results {
            margin-top: 20px;
        }

        .bus-option {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
        }

        .close {
            float: right;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Bus Booking</h1>

    <!-- Search Form -->
    <div class="search-form">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="departure">Departure:</label>
            <input type="text" name="departure" required>

            <label for="destination">Destination:</label>
            <input type="text" name="destination" required>

            <label for="date">Date of Travel:</label>
            <input type="date" name="date" required>

            <button type="submit" name="search">Search Buses</button>
        </form>
    </div>

    <!-- Display Search Results -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
        // Include search results
        echo '<div class="search-results">
                  <h2>Search Results</h2>
                  <div class="bus-option">
                      <span>Bus A</span>
                      <span>Departure: 08:00 AM</span>
                      <span>Arrival: 01:00 PM</span>
                      <span>Price: $50</span>
                      <button onclick="selectSeat()">Select Seat</button>
                  </div>
                  <!-- Repeat for other bus options -->
                  <!-- Seat Selection Modal -->
                  <div id="seatSelectionModal" class="modal">
                      <div class="modal-content">
                          <span class="close" onclick="closeModal()">&times;</span>
                          <h3>Select Your Seat</h3>
                          <!-- Display Seat Layout -->
                          <div class="seat-layout">
                              <!-- Interactive seat selection area -->
                          </div>
                          <button onclick="confirmBooking()">Confirm Booking</button>
                      </div>
                  </div>
              </div>';
    }
    ?>

</div>

<script>
    // JavaScript goes here
    function selectSeat() {
        document.getElementById('seatSelectionModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('seatSelectionModal').style.display = 'none';
    }

    function confirmBooking() {
        alert('Booking confirmed!');
        closeModal();
    }
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Generations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<h1 style="text-align:center;">Latest Generations</h1>
<div class="container mt-4">
    <table class="table table-bordered" id="records-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Prompt</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody id="records-body">
            <!-- Records will be dynamically updated here -->
        </tbody>
    </table>
</div>

<script>
    // Function to fetch and update records
    function fetchRecords() {
        $.ajax({
            url: 'fetch_records.php',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                // Clear existing content
                $('#records-body').empty();

                // Append new records
                data.forEach(function(record) {
                    var recordHtml = '<tr>';
                    recordHtml += '<td>' + record.id + '</td>';
                    recordHtml += '<td>' + record.prompt + '</td>';
                    recordHtml += '<td><img src="' + record.image + '" alt="Image" width="200"></td>';
                    recordHtml += '</tr>';
                    $('#records-body').append(recordHtml);
                });
            },
            error: function (error) {
                console.error('Error fetching records:', error);
            }
        });
    }

    // Initial fetch
    fetchRecords();

    // Set interval for auto-refresh (e.g., every 10 seconds)
    setInterval(fetchRecords, 10000); // Adjust the interval as needed
</script>

</body>
</html>

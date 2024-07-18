<?php
include 'config/database.php'; // Database connection
// Allow direct access without authentication
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="sidebar">
        <a href="admin.php">Dashboard</a>
        <a href="blog.php" target="_blank">View Homepage</a>
        <a href="add-post.php">Add Post</a>
        <a href="manage-posts.php" class="active">Manage Posts</a>
        <a href="review-posts.php">Review Post</a>
        <a href="reports.php">Reports</a>
        <a href="manage-users.php">Manage Users</a>
        <a href="add-category.php">Add Category</a>
    </div>

    <div class="main-content">
        <h1>Welcome to Admin Panel</h1>

        <section class="admin__actions">
            <h2>Manage Posts</h2>
            <?php
            // Fetch all posts
            $query = "SELECT * FROM posts";
            $result = mysqli_query($connection, $query);

            if (mysqli_num_rows($result) > 0) {
                echo '<table>';
                echo '<tr><th>Title</th><th>Category</th><th>Author</th><th>Delete</th></tr>';
                while ($post = mysqli_fetch_assoc($result)) {
                    // Fetch category info
                    $category_id = $post['category_id'];
                    $category_query = "SELECT * FROM categories WHERE id=$category_id";
                    $category_result = mysqli_query($connection, $category_query);
                    $category = mysqli_fetch_assoc($category_result);

                    // Fetch author info
                    $author_id = $post['author_id'];
                    $author_query = "SELECT * FROM users WHERE id=$author_id";
                    $author_result = mysqli_query($connection, $author_query);
                    $author = mysqli_fetch_assoc($author_result);

                    echo '<tr>';
                    echo '<td>' . $post['title'] . '</td>';
                    echo '<td>' . $category['title'] . '</td>';
                    echo '<td>' . $author['firstname'] . ' ' . $author['lastname'] . '</td>';
                    echo '<td><a href="delete-post.php?id=' . $post['id'] . '" class="btn red-btn">Delete</a></td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo 'No posts found.';
            }
            ?>
        </section>

        <section class="admin__actions">
            <h2>Review Posts</h2>
            <?php
            // Fetch posts needing review
            $review_query = "SELECT * FROM posts WHERE status='pending'";
            $review_result = mysqli_query($connection, $review_query);

            if (mysqli_num_rows($review_result) > 0) {
                echo '<table>';
                echo '<tr><th>Title</th><th>Category</th><th>Author</th><th>Approve</th><th>View</th></tr>';
                while ($post = mysqli_fetch_assoc($review_result)) {
                    // Fetch category info
                    $category_id = $post['category_id'];
                    $category_query = "SELECT * FROM categories WHERE id=$category_id";
                    $category_result = mysqli_query($connection, $category_query);
                    $category = mysqli_fetch_assoc($category_result);

                    // Fetch author info
                    $author_id = $post['author_id'];
                    $author_query = "SELECT * FROM users WHERE id=$author_id";
                    $author_result = mysqli_query($connection, $author_query);
                    $author = mysqli_fetch_assoc($author_result);

                    echo '<tr>';
                    echo '<td>' . $post['title'] . '</td>';
                    echo '<td>' . $category['title'] . '</td>';
                    echo '<td>' . $author['firstname'] . ' ' . $author['lastname'] . '</td>';
                    echo '<td><a href="approve-post.php?id=' . $post['id'] . '" class="btn">Approve</a></td>';
                    echo '<td><a href="view-post.php?id=' . $post['id'] . '" class="btn">View</a></td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo 'No posts awaiting review.';
            }
            ?>
        </section>

        <section class="admin__actions">
            <h2>Reports</h2>
            <?php
            // Fetch all reports
            $report_query = "SELECT * FROM reports";
            $report_result = mysqli_query($connection, $report_query);

            if (mysqli_num_rows($report_result) > 0) {
                echo '<table>';
                echo '<tr><th>Post ID</th><th>Reported By</th><th>Reason</th><th>Delete</th></tr>';
                while ($report = mysqli_fetch_assoc($report_result)) {
                    // Fetch user who reported
                    $reporter_id = $report['reported_by'];
                    $reporter_query = "SELECT * FROM users WHERE id=$reporter_id";
                    $reporter_result = mysqli_query($connection, $reporter_query);
                    $reporter = mysqli_fetch_assoc($reporter_result);

                    echo '<tr>';
                    echo '<td>' . $report['post_id'] . '</td>';
                    echo '<td>' . $reporter['firstname'] . ' ' . $reporter['lastname'] . '</td>';
                    echo '<td>' . $report['reason'] . '</td>';
                    echo '<td><a href="delete-report.php?id=' . $report['id'] . '" class="btn red-btn">Delete</a></td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo 'No reports found.';
            }
            ?>
        </section>

        <section class="admin__actions">
            <h2>Manage Users</h2>
            <?php
            // Fetch all users
            $user_query = "SELECT * FROM users";
            $user_result = mysqli_query($connection, $user_query);

            if (mysqli_num_rows($user_result) > 0) {
                echo '<table>';
                echo '<tr><th>Firstname</th><th>Lastname</th><th>Email</th><th>Delete</th></tr>';
                while ($user = mysqli_fetch_assoc($user_result)) {
                    echo '<tr>';
                    echo '<td>' . $user['firstname'] . '</td>';
                    echo '<td>' . $user['lastname'] . '</td>';
                    echo '<td>' . $user['email'] . '</td>';
                    echo '<td><a href="delete-user.php?id=' . $user['id'] . '" class="btn red-btn">Delete</a></td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo 'No users found.';
            }
            ?>
        </section>

        <section class="admin__actions">
            <h2>Add Category</h2>
            <form action="add-category.php" method="POST">
                <input type="text" name="title" placeholder="Category Title" required>
                <button type="submit" class="btn">Add Category</button>
            </form>
        </section>
    </div>
</body>
</html>

<?php
if (isset($_POST['query'])) {
    $search = $_POST['query'];
    
    $url = "https://www.googleapis.com/books/v1/volumes?q=" . urlencode($search) . "&key=AIzaSyA6SaT23KNiiA6DnUfUQTvFeyAcQEkwnSU";
    
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    
    if (isset($data['items']) && count($data['items']) > 0) {
        foreach ($data['items'] as $item) {
            $book = $item['volumeInfo'];
            $title = $book['title'];
            $authors = isset($book['authors']) ? implode(', ', $book['authors']) : 'Unknown Author';
            $thumbnail = isset($book['imageLinks']['thumbnail']) ? $book['imageLinks']['thumbnail'] : 'default-thumbnail.jpg';
            
            echo '<a href="#" class="suggestion-item">';
            echo '<div><strong>' . $title . '</strong></div>';
            echo '<div>' . $authors . '</div>';
            echo '<img src="' . $thumbnail . '" alt="' . $title . '">';
            echo '</a>';
        }
    } else {
        echo '<div class="no-suggestions">No suggestions found</div>';
    }
}
?>
<style>
  .suggestion-item {
    padding: 10px;
    border-bottom: 1px solid #ccc;
    text-decoration: none;
    color: #333;
    display: block;
  }

  .no-suggestions {
    padding: 10px;
    color: #777;
  }
</style>

<?php
// template.php

function displayCategories($bdd) {
    $categoriesQuery = $bdd->query('SELECT * FROM categories');

    echo '<div class="categories-container">';
    echo '<h2 class="text-primary">Categories</h2>';

    while ($category = $categoriesQuery->fetch()) {
        echo '<div class="category-item bg-info p-2 mb-2 rounded">';
        echo '<a href="index.php?categorie=' . htmlspecialchars($category['name']) . '" class="text-white">';
        echo htmlspecialchars($category['name']);
        echo '</a>';
        echo '</div>';
    }

    echo '</div>';
}

function displayMainPage($bdd, $sujet = null, $categorie = null) {
    if ($categorie) {
        echo '<div class="categories bg-teal text-white p-3 rounded mb-3">';
        echo '<h2>' . htmlspecialchars($categorie) . '</h2>';
        echo '</div>';

        $requete = $bdd->prepare('SELECT * FROM sujet WHERE categorie = :categorie');
        $requete->execute(['categorie' => $categorie]);
        while ($reponse = $requete->fetch()) {
            echo '<div class="categories bg-info p-2 mb-2 rounded">';
            echo '<a href="index.php?sujet=' . htmlspecialchars($reponse['name']) . '" class="text-white">';
            echo htmlspecialchars($reponse['name']);
            echo '</a>';
            echo '</div>';
        }
    } elseif ($sujet) {
        echo '<div class="categories bg-teal text-white p-3 rounded mb-3">';
        echo '<h2>' . htmlspecialchars($sujet) . '</h2>';
        echo '</div>';

        $requete = $bdd->prepare('SELECT * FROM postSujet WHERE sujet = :sujet');
        $requete->execute(['sujet' => $sujet]);
        while ($post = $requete->fetch()) {
            echo '<div class="post bg-purple text-white p-3 mb-3 rounded">';
            echo '<strong>' . htmlspecialchars($post['propri']) . ':</strong><br>';
            echo htmlspecialchars($post['contenu']);
            echo '</div>';
        }
    } else {
        echo '<div class="main-content text-center">';
        echo '<h2 class="text-primary">Welcome to the Forum</h2>';
        echo '<p class="lead">Choose a category to start exploring topics!</p>';
        echo '</div>';
    }
}
?>
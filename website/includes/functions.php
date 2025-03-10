<?php
// En funktion til at generere en brødkrummesti for at vise navigationen.
function generateBreadcrumb($categories) {
    // Starter med en tom brødkrummesti
    $breadcrumb = "<nav aria-label='breadcrumb'><ol class='breadcrumb'>";

    // Går igennem hver kategori for at opbygge stien
    foreach ($categories as $key => $category) {
        if ($key === array_key_last($categories)) {
            $breadcrumb .= "<li class='breadcrumb-item active' aria-current='page'>{$category}</li>";
        } else {
            $breadcrumb .= "<li class='breadcrumb-item'><a href='?category={$key}'>{$category}</a></li>";
        }
    }

    // Lukker brødkrummestien
    $breadcrumb .= "</ol></nav>";

    return $breadcrumb;
}

// En funktion til at generere en dynamisk kategori-listevisning
function generateCategoryList($categories, $activeCategory, $activeSubCategory = null, $activeProduct = null) {
    $list = "<div class='kategori-listevisning hidden'>";

    foreach ($categories as $category => $name) {
        $class = ($category === $activeCategory) ? 'active' : 'unactive';
        $list .= "<a href='{$name}.php'><div class='{$class}'>{$name}</div></a>";
    }

    $list .= "</div>";
    return $list;
}
?>

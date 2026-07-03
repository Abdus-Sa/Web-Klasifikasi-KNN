<?php
$conn = new mysqli('localhost', 'root', '', 'knn');
$conn->query("ALTER TABLE dataset ADD COLUMN klasifikasi VARCHAR(255) NULL;");
echo "Added klasifikasi";

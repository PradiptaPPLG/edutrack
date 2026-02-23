<?php
// public/test-upload.php
$targetDir = __DIR__ . '/storage/profile-photos/';
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

echo "<h3>Test Upload File</h3>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['photo'];
        $filename = time() . '_' . basename($file['name']);
        $targetFile = $targetDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            echo "<p style='color:green'>✓ SUCCESS: File tersimpan</p>";
            echo "<p>Lokasi: " . $targetFile . "</p>";
            echo "<p>URL: " . asset('storage/profile-photos/' . $filename) . "</p>";
            
            // Cek apakah file benar-benar ada
            if (file_exists($targetFile)) {
                echo "<p style='color:green'>✓ File benar-benar ada di folder</p>";
            }
        } else {
            echo "<p style='color:red'>✗ Gagal memindahkan file</p>";
        }
    } else {
        $error = $_FILES['photo']['error'] ?? 'Tidak ada file';
        echo "<p style='color:red'>✗ Error upload: " . $error . "</p>";
    }
}
?>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="photo" required>
    <button type="submit">Upload Test</button>
</form>

<p><strong>Info Folder:</strong></p>
<?php
echo "Folder target: " . $targetDir . "<br>";
echo "Folder exists: " . (file_exists($targetDir) ? 'Ya' : 'Tidak') . "<br>";
echo "Folder writable: " . (is_writable($targetDir) ? 'Ya' : 'Tidak') . "<br>";
?>
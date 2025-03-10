<?php
include "config.php";

$result = $conn->query("SELECT * FROM pengumpulan_tugas ORDER BY tanggal_kirim DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas</title>
    <style>
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>

    <h2 style="text-align: center;">Daftar Tugas yang Telah Dikumpulkan</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>File</th>
            <th>Tanggal Kirim</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo htmlspecialchars($row["nama"]); ?></td>
                <td><?php echo htmlspecialchars($row["email"]); ?></td>
                <td><a href="uploads/<?php echo $row["file_tugas"]; ?>" target="_blank">Lihat File</a></td>
                <td><?php echo $row["tanggal_kirim"]; ?></td>
            </tr>
        <?php } ?>
    </table>

</body>
</html>

<?php
$conn->close();
?>

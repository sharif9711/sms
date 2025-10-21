<?php
include_once '../../common.php';
header('Content-Type: application/json; charset=utf-8');

if (!$is_member) {
    echo json_encode(['success' => false, 'message' => '로그인이 필요합니다.']);
    exit;
}

$mb_id = $member['mb_id'];

// 프로젝트 목록 조회
$sql = "SELECT * FROM g5_map_projects WHERE mb_id = '{$mb_id}' ORDER BY updated_at DESC";
$result = sql_query($sql);

$projects = [];
while ($row = sql_fetch_array($result)) {
    $projects[] = [
        'id' => $row['project_id'],
        'projectName' => $row['project_name'],
        'mapType' => $row['map_type'],
        'createdAt' => $row['created_at'],
        'data' => json_decode($row['project_data'], true)
    ];
}

echo json_encode([
    'success' => true,
    'projects' => $projects
]);
?>

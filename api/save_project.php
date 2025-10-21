<?php
define('_GNUBOARD_', true);
include_once '../../../common.php';
header('Content-Type: application/json; charset=utf-8');

if (!$is_member) {
    echo json_encode(['success' => false, 'message' => '로그인이 필요합니다.']);
    exit;
}

// POST 데이터 받기
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => '데이터가 없습니다.']);
    exit;
}

$mb_id = $member['mb_id'];
$project_id = sql_real_escape_string($input['id']);
$project_name = sql_real_escape_string($input['projectName']);
$map_type = sql_real_escape_string($input['mapType']);
$project_data = sql_real_escape_string(json_encode($input['data']));
$created_at = $input['createdAt'];

// 기존 프로젝트 확인
$check_sql = "SELECT id FROM g5_map_projects WHERE mb_id = '{$mb_id}' AND project_id = '{$project_id}'";
$check = sql_fetch($check_sql);

if ($check) {
    // 업데이트
    $sql = "UPDATE g5_map_projects SET 
            project_name = '{$project_name}',
            map_type = '{$map_type}',
            project_data = '{$project_data}',
            updated_at = NOW()
            WHERE mb_id = '{$mb_id}' AND project_id = '{$project_id}'";
} else {
    // 새로 저장
    $sql = "INSERT INTO g5_map_projects 
            (mb_id, project_id, project_name, map_type, project_data, created_at, updated_at) 
            VALUES 
            ('{$mb_id}', '{$project_id}', '{$project_name}', '{$map_type}', '{$project_data}', '{$created_at}', NOW())";
}

$result = sql_query($sql);

echo json_encode([
    'success' => $result ? true : false,
    'message' => $result ? '저장 성공' : '저장 실패'
]);
?>

<?php
include_once '../../common.php';
header('Content-Type: application/json; charset=utf-8');

// 로그인 확인
if (!$is_member) {
    echo json_encode([
        'success' => false,
        'message' => '로그인이 필요합니다.'
    ]);
    exit;
}

// JSON 데이터 읽기
$input = json_decode(file_get_contents('php://input'), true);
if (!$input || empty($input['projectName'])) {
    echo json_encode([
        'success' => false,
        'message' => '프로젝트 데이터가 잘못되었습니다.'
    ]);
    exit;
}

// 기본 변수
$mb_id = $member['mb_id'];
$project_id = sql_real_escape_string($input['id'] ?? uniqid()); // id 없을 경우 자동생성
$project_name = sql_real_escape_string($input['projectName']);
$map_type = sql_real_escape_string($input['mapType'] ?? 'vworld');
$project_data = sql_real_escape_string(json_encode($input['data'] ?? []));
$now = date('Y-m-d H:i:s');

// 기존 프로젝트 존재 여부 확인
$check_sql = "SELECT project_id FROM g5_map_projects WHERE mb_id = '{$mb_id}' AND project_id = '{$project_id}'";
$check = sql_fetch($check_sql);

// SQL 분기
if ($check) {
    // 업데이트
    $sql = "
        UPDATE g5_map_projects 
        SET project_name = '{$project_name}',
            map_type = '{$map_type}',
            project_data = '{$project_data}',
            updated_at = '{$now}'
        WHERE mb_id = '{$mb_id}' AND project_id = '{$project_id}'
    ";
} else {
    // 신규 저장
    $sql = "
        INSERT INTO g5_map_projects 
        (mb_id, project_id, project_name, map_type, project_data, created_at, updated_at)
        VALUES
        ('{$mb_id}', '{$project_id}', '{$project_name}', '{$map_type}', '{$project_data}', '{$now}', '{$now}')
    ";
}

$result = sql_query($sql);

echo json_encode([
    'success' => $result ? true : false,
    'message' => $result ? '프로젝트가 저장되었습니다.' : '저장 중 오류가 발생했습니다.',
    'project_id' => $project_id
]);
?>

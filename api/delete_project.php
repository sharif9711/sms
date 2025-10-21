<?php
define('_GNUBOARD_', true);
include_once '../../../common.php';
header('Content-Type: application/json; charset=utf-8');

if (!$is_member) {
    echo json_encode(['success' => false, 'message' => '로그인이 필요합니다.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['project_id'])) {
    echo json_encode(['success' => false, 'message' => '프로젝트 ID가 없습니다.']);
    exit;
}

$mb_id = $member['mb_id'];
$project_id = sql_real_escape_string($input['project_id']);

$sql = "DELETE FROM g5_map_projects WHERE mb_id = '{$mb_id}' AND project_id = '{$project_id}'";
$result = sql_query($sql);

echo json_encode([
    'success' => $result ? true : false,
    'message' => $result ? '삭제 성공' : '삭제 실패'
]);
?>
```

---

### 3️⃣ **파일 업로드 완료 후 확인**

브라우저에서 직접 테스트:
```
https://ftpsharif.dothome.co.kr/html/map/api/auth.php

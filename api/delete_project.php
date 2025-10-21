<?php
define('_GNUBOARD_', true);
include_once '../../common.php';  // ✅ 수정
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

## 📤 업로드 및 테스트

### 1️⃣ **4개 파일 모두 재업로드**

수정한 파일들을 FTP로 `/html/map/api/` 폴더에 덮어쓰기 하세요.

### 2️⃣ **auth.php 테스트**

브라우저에서:
```
https://ftpsharif.dothome.co.kr/html/map/api/auth.php

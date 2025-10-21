<?php
// 그누보드 경로 설정
define('_GNUBOARD_', true);

// ✅ 경로 수정: ../../../ → ../../
include_once '../../common.php';

header('Content-Type: application/json; charset=utf-8');

// 로그인 여부 확인
if (!$is_member) {
    echo json_encode([
        'success' => false,
        'message' => '로그인이 필요합니다.',
        'mb_id' => null
    ]);
    exit;
}

// 로그인된 사용자 정보 반환
echo json_encode([
    'success' => true,
    'mb_id' => $member['mb_id'],
    'mb_name' => $member['mb_name'],
    'mb_nick' => $member['mb_nick']
]);
?>

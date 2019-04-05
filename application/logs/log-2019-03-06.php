<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-03-06 06:16:18 --> Severity: error --> Exception: syntax error, unexpected '', b.Last_Name) as Name'' (T_CONSTANT_ENCAPSED_STRING), expecting ',' or ')' C:\xampp\htdocs\works\otelseasy\application\models\Booking_Model.php 675
ERROR - 2019-03-06 06:16:31 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`id` USING (`inner`)
WHERE `a`.`bookId` = '1'' at line 3 - Invalid query: SELECT `a`.*, CONCAT(b.First_Name, " ", b.Last_Name) as Name
FROM `hotel_tbl_hotelBookingRemarks` `a`
JOIN `hotel_tbl_user b on a`.`createdBy =` `b`.`id` USING (`inner`)
WHERE `a`.`bookId` = '1'
ERROR - 2019-03-06 06:16:42 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '.`id` USING (`left`)
WHERE `a`.`bookId` = '1'' at line 3 - Invalid query: SELECT `a`.*, CONCAT(b.First_Name, " ", b.Last_Name) as Name
FROM `hotel_tbl_hotelBookingRemarks` `a`
JOIN `hotel_tbl_user b on a`.`createdBy =` `b`.`id` USING (`left`)
WHERE `a`.`bookId` = '1'
ERROR - 2019-03-06 06:53:44 --> Query error: Unknown column 'a.bookId' in 'where clause' - Invalid query: DELETE FROM `hotel_tbl_hotelBookingRemarks`
WHERE `a`.`bookId` = '1'
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 34
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'hotel_name' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 34
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 45
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'location' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 45
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 54
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'Created_Date' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 54
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 63
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'sale_number' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 63
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 76
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'sale_address' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 76
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 91
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'AFName' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 91
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 91
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'ALName' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 91
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 106
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'booking_flag' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 106
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 106
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'booking_flag' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 106
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 108
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'booking_flag' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 108
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 110
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'booking_flag' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 110
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 117
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'bkid' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 117
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 118
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'hotel_id' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 118
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 119
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'agent_id' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 119
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 124
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'booking_id' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 124
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 125
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'room_name' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 125
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 125
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'Room_Type' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 125
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 127
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'booking_date' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 127
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 129
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'nationality' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 129
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 131
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'boardName' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 131
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 140
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'adults_count' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 140
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 143
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'childs_count' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 143
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 162
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'book_room_count' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 162
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 193
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'no_of_days' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 193
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 194
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'book_room_count' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 194
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 195
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'check_in' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 195
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 197
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'check_out' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 197
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 219
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'contract_id' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 219
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 220
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'booking_flag' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 220
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 228
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'agent_markup' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 228
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 228
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'admin_markup' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 228
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 228
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'search_markup' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 228
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 229
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'book_room_count' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 229
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 230
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'individual_amount' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 230
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 231
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'individual_discount' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 231
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 232
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'check_in' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 232
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 233
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'check_out' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 233
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 540
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'tax' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 540
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined variable: total C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 544
ERROR - 2019-03-06 06:54:17 --> Severity: Warning --> array_sum() expects parameter 1 to be array, null given C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 544
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 544
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'tax' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 544
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined variable: total C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 544
ERROR - 2019-03-06 06:54:17 --> Severity: Warning --> array_sum() expects parameter 1 to be array, null given C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 544
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined variable: witotal C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 545
ERROR - 2019-03-06 06:54:17 --> Severity: Warning --> array_sum() expects parameter 1 to be array, null given C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 545
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 545
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'tax' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 545
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined variable: witotal C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 545
ERROR - 2019-03-06 06:54:17 --> Severity: Warning --> array_sum() expects parameter 1 to be array, null given C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 545
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined variable: totalNotMar C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 546
ERROR - 2019-03-06 06:54:17 --> Severity: Warning --> array_sum() expects parameter 1 to be array, null given C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 546
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 546
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'tax' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 546
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined variable: totalNotMar C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 546
ERROR - 2019-03-06 06:54:17 --> Severity: Warning --> array_sum() expects parameter 1 to be array, null given C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 546
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined variable: costPrice C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 570
ERROR - 2019-03-06 06:54:17 --> Severity: Warning --> array_sum() expects parameter 1 to be array, null given C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 570
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 573
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'discount' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 573
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 574
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'admin_markup' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 574
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 575
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'agent_markup' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 575
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 617
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'SpecialRequest' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 617
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 742
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'bkid' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 742
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 743
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'hotel_id' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 743
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 744
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'agent_id' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 744
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 808
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'bkid' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 808
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 809
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'hotel_id' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 809
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 810
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'agent_id' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 810
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 818
ERROR - 2019-03-06 06:54:17 --> Severity: Notice --> Trying to get property 'booking_flag' of non-object C:\xampp\htdocs\works\otelseasy\application\views\backend\booking\hotel_booking_view.php 818
ERROR - 2019-03-06 08:00:15 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 08:00:16 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:18:29 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:18:29 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:20:00 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:20:00 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:21:34 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:21:34 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:21:45 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:21:45 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:21:51 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:21:51 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:22:34 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:22:34 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:23:11 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:23:11 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:24:31 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:24:31 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:24:33 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:24:33 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:24:33 --> Severity: Notice --> Undefined index: Child C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 13
ERROR - 2019-03-06 13:24:33 --> Severity: Notice --> Undefined index: providers C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 106
ERROR - 2019-03-06 13:24:33 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:24:33 --> Severity: Notice --> Undefined index: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 318
ERROR - 2019-03-06 13:24:33 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 329
ERROR - 2019-03-06 13:24:33 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:24:33 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:24:34 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:24:34 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '<div style=' at line 2 - Invalid query: SELECT sortname FROM countries where id = 
<div style=
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:24:34 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:24:34 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:24:34 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:27:02 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:27:02 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:27:02 --> Severity: Notice --> Undefined index: providers C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 106
ERROR - 2019-03-06 13:27:02 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:27:02 --> Severity: Notice --> Undefined index: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 318
ERROR - 2019-03-06 13:27:02 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 329
ERROR - 2019-03-06 13:27:02 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:27:02 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:27:03 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:27:03 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '<div style=' at line 2 - Invalid query: SELECT sortname FROM countries where id = 
<div style=
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:27:03 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:27:03 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:27:03 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:27:17 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:27:17 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:27:17 --> Severity: Notice --> Undefined index: Child C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 13
ERROR - 2019-03-06 13:27:17 --> Severity: Notice --> Undefined index: providers C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 106
ERROR - 2019-03-06 13:27:17 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:27:17 --> Severity: Notice --> Undefined index: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 318
ERROR - 2019-03-06 13:27:17 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 329
ERROR - 2019-03-06 13:27:18 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '<div style=' at line 2 - Invalid query: SELECT sortname FROM countries where id = 
<div style=
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:27:18 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:27:18 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:27:18 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:27:18 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:28:13 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:28:13 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:28:13 --> Severity: Notice --> Undefined index: providers C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 106
ERROR - 2019-03-06 13:28:13 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:28:13 --> Severity: Notice --> Undefined index: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 318
ERROR - 2019-03-06 13:28:13 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 329
ERROR - 2019-03-06 13:28:13 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:28:13 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:14 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:28:14 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '<div style=' at line 2 - Invalid query: SELECT sortname FROM countries where id = 
<div style=
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:14 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:28:14 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:28:14 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:28:18 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:28:18 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:28:18 --> Severity: Notice --> Undefined index: providers C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 106
ERROR - 2019-03-06 13:28:18 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:28:18 --> Severity: Notice --> Undefined index: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 318
ERROR - 2019-03-06 13:28:18 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:28:18 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:28:19 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '<div style=' at line 2 - Invalid query: SELECT sortname FROM countries where id = 
<div style=
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:19 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:28:19 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:19 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:28:19 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:28:22 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:28:22 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:28:22 --> Severity: Notice --> Undefined index: providers C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 106
ERROR - 2019-03-06 13:28:22 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:28:22 --> Severity: Notice --> Undefined index: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 318
ERROR - 2019-03-06 13:28:22 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:28:22 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:23 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:28:23 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '<div style=' at line 2 - Invalid query: SELECT sortname FROM countries where id = 
<div style=
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:23 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:28:23 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:28:23 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:28:30 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:28:30 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined index: providers C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 106
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined index: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 318
ERROR - 2019-03-06 13:28:30 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:28:30 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:28:30 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '<div style=' at line 2 - Invalid query: SELECT sortname FROM countries where id = 
<div style=
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:28:30 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:28:30 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:28:33 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:28:33 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined index: providers C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 106
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined index: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 318
ERROR - 2019-03-06 13:28:33 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 329
ERROR - 2019-03-06 13:28:33 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:28:33 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:28:33 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '<div style=' at line 2 - Invalid query: SELECT sortname FROM countries where id = 
<div style=
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:33 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:28:33 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:33 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:28:33 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:29:53 --> 404 Page Not Found: Skin/images
ERROR - 2019-03-06 13:29:53 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:29:53 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:29:54 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:29:55 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:29:55 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:30:25 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:30:25 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:30:25 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:30:25 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:30:59 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:30:59 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:30:59 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:30:59 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\models\List_Model.php 1132
ERROR - 2019-03-06 13:30:59 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:30:59 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:30:59 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:30:59 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:30:59 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:30:59 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:30:59 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:30:59 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:30:59 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:30:59 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:30:59 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:30:59 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:30:59 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:30:59 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:30:59 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:30:59 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:30:59 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:30:59 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:31:00 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:31:00 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined index: providers C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 106
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined index: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 318
ERROR - 2019-03-06 13:32:10 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 329
ERROR - 2019-03-06 13:32:10 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:32:10 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:32:10 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:32:10 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '<div style=' at line 2 - Invalid query: SELECT sortname FROM countries where id = 
<div style=
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:32:10 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:32:10 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:32:11 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:32:11 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:32:30 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:32:30 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:32:30 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:32:30 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:32:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:32:30 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:32:30 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:32:30 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:32:30 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:32:30 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:32:30 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:32:30 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:32:30 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:32:30 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:32:30 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:32:30 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:32:30 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:32:30 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:32:31 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:32:31 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined index: providers C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 106
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined index: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 318
ERROR - 2019-03-06 13:32:33 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 329
ERROR - 2019-03-06 13:32:33 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:32:33 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:32:33 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '<div style=' at line 2 - Invalid query: SELECT sortname FROM countries where id = 
<div style=
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:32:33 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:32:33 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:32:33 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:32:33 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:32:42 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:32:42 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:32:43 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:32:43 --> Severity: Notice --> Undefined index: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 318
ERROR - 2019-03-06 13:32:43 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:32:43 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:32:44 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:32:44 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:32:44 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:32:44 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:33:13 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:33:13 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:33:13 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:33:13 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:33:13 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:33:13 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:33:13 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:33:13 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:33:13 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:33:13 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:33:13 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:33:13 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:33:13 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:33:13 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:33:13 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:33:13 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:33:13 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:33:13 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:33:13 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:33:13 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:33:31 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:33:31 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:33:35 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:33:35 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:33:35 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:33:36 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:33:36 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:33:36 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:33:36 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:33:36 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:33:36 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:33:36 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:33:36 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:33:36 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:33:36 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:33:36 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:33:36 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:33:36 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:33:36 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:33:36 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:33:36 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:33:36 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:33:38 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:33:38 --> 404 Page Not Found: Skin/images
ERROR - 2019-03-06 13:33:38 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:33:38 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:33:39 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:33:39 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:33:40 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:33:40 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:33:44 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:33:44 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:33:45 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:33:45 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:33:45 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:33:45 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:33:45 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:33:45 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:35:09 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:35:09 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:35:09 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:35:10 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:35:10 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:35:10 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:35:10 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:35:10 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:35:10 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:35:10 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:35:10 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:35:10 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:35:10 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:35:10 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:35:10 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:35:10 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:35:10 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:35:10 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:35:10 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:35:10 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:37:03 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:37:03 --> Severity: Notice --> Undefined variable: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 391
ERROR - 2019-03-06 13:37:03 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 391
ERROR - 2019-03-06 13:37:03 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:37:03 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:37:03 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:37:03 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:37:03 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:37:03 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:37:03 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:37:03 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:37:03 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:37:03 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:37:03 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:37:03 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:37:03 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:37:03 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:37:03 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:37:03 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:37:03 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:37:04 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:37:04 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:37:14 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:37:14 --> Severity: Notice --> Undefined variable: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 391
ERROR - 2019-03-06 13:37:14 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 391
ERROR - 2019-03-06 13:37:14 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:37:14 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:37:15 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:37:15 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:37:15 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:37:15 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:37:15 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:37:15 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:37:15 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:37:15 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:37:15 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:37:15 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:37:15 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:37:15 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:37:15 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:37:15 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:37:15 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:37:15 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:37:15 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:37:25 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:37:25 --> Severity: Notice --> Undefined variable: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 391
ERROR - 2019-03-06 13:37:25 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 391
ERROR - 2019-03-06 13:37:25 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:37:25 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:37:25 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:37:25 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:37:25 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:37:25 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:37:25 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:37:25 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:37:25 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:37:25 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:37:25 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:37:25 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:37:25 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:37:25 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:37:25 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:37:25 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:37:25 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:37:26 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:37:26 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:37:32 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:37:32 --> Severity: Notice --> Undefined variable: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 391
ERROR - 2019-03-06 13:37:32 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 391
ERROR - 2019-03-06 13:37:32 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:37:32 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:37:32 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:37:32 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:37:32 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:37:32 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:37:32 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:37:32 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:37:32 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:37:32 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:37:32 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:37:32 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:37:32 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:37:32 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:37:32 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:37:32 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:37:32 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:37:33 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:37:33 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:38:08 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:38:08 --> Severity: Notice --> Undefined variable: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 391
ERROR - 2019-03-06 13:38:08 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 391
ERROR - 2019-03-06 13:38:09 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:38:09 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:38:09 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:38:09 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:38:09 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:38:09 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:38:09 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:38:09 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:38:09 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:38:09 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:38:09 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:38:09 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:38:09 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:38:09 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:38:09 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:38:09 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:38:09 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:38:09 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:38:09 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:38:29 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:38:29 --> Severity: Notice --> Undefined variable: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 335
ERROR - 2019-03-06 13:38:29 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 335
ERROR - 2019-03-06 13:38:29 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:38:29 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:38:30 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:38:30 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:38:30 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:38:30 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:38:30 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:38:30 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:38:30 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:38:30 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:38:30 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:38:30 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:38:30 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:38:30 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:38:30 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:38:30 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:38:30 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:38:31 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:38:31 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:38:48 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:38:48 --> Severity: Notice --> Undefined variable: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 391
ERROR - 2019-03-06 13:38:48 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 391
ERROR - 2019-03-06 13:38:48 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:38:48 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:38:48 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:38:48 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:38:48 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:38:48 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:38:48 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:38:48 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:38:48 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:38:48 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:38:48 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:38:48 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:38:48 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:38:48 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:38:48 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:38:48 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:38:48 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:38:49 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:38:49 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:38:52 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:38:52 --> Severity: Notice --> Undefined variable: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 391
ERROR - 2019-03-06 13:38:52 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 391
ERROR - 2019-03-06 13:38:52 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:38:52 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:38:53 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:38:53 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:38:53 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:38:53 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:38:53 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:38:53 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:38:53 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:38:53 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:38:53 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:38:53 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:38:53 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:38:53 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:38:53 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:38:53 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:38:53 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:38:53 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:38:53 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:40:01 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:40:01 --> Severity: Notice --> Undefined variable: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 335
ERROR - 2019-03-06 13:40:01 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 335
ERROR - 2019-03-06 13:40:01 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:40:01 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:40:02 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:40:02 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:40:02 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:40:02 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:40:02 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:40:02 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:40:02 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:40:02 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:40:02 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:40:02 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:40:02 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:40:02 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:40:02 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:40:02 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:40:02 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:40:02 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:40:02 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:40:16 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:40:16 --> Severity: Notice --> Undefined variable: nationality C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 335
ERROR - 2019-03-06 13:40:16 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 335
ERROR - 2019-03-06 13:40:16 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:40:16 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:40:16 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:40:16 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 332
ERROR - 2019-03-06 13:40:16 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 399
ERROR - 2019-03-06 13:40:16 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 400
ERROR - 2019-03-06 13:40:16 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:40:16 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:40:16 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:40:16 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:40:16 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:40:16 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:40:16 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:40:16 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:40:16 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:40:16 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:40:16 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:40:16 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:40:16 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 485
ERROR - 2019-03-06 13:41:44 --> Severity: Notice --> Undefined property: Details::$list_Model C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 54
ERROR - 2019-03-06 13:41:44 --> Severity: error --> Exception: Call to a member function getNationality() on null C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 54
ERROR - 2019-03-06 13:41:58 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:41:59 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:41:59 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:41:59 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 334
ERROR - 2019-03-06 13:41:59 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 334
ERROR - 2019-03-06 13:41:59 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:41:59 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:41:59 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:41:59 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:41:59 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:41:59 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:41:59 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:41:59 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:41:59 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:41:59 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:41:59 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:41:59 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 412
ERROR - 2019-03-06 13:41:59 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 413
ERROR - 2019-03-06 13:41:59 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:41:59 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:42:45 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:42:45 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:42:45 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:42:46 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 334
ERROR - 2019-03-06 13:42:46 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 334
ERROR - 2019-03-06 13:42:46 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:42:46 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:42:46 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:42:46 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:42:46 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:42:46 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:42:46 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:42:46 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:42:46 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:42:46 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:42:46 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:42:46 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 412
ERROR - 2019-03-06 13:42:46 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 413
ERROR - 2019-03-06 13:42:46 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:42:46 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:44:11 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:44:11 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:44:11 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:44:12 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 334
ERROR - 2019-03-06 13:44:12 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 334
ERROR - 2019-03-06 13:44:12 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:44:12 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:44:12 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:44:12 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:44:12 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:44:12 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:44:12 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:44:12 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:44:12 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:44:12 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:44:12 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:44:12 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 412
ERROR - 2019-03-06 13:44:12 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 413
ERROR - 2019-03-06 13:44:12 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:44:12 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:44:15 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:44:15 --> 404 Page Not Found: Skin/images
ERROR - 2019-03-06 13:44:15 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:44:16 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:44:17 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:44:17 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:44:17 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:44:17 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:46:14 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:46:14 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:46:14 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:46:15 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 334
ERROR - 2019-03-06 13:46:15 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 334
ERROR - 2019-03-06 13:46:15 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:46:15 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:46:15 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:46:15 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:46:15 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:46:15 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:46:15 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:46:15 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:46:15 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:46:15 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:46:15 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:46:15 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 412
ERROR - 2019-03-06 13:46:15 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 413
ERROR - 2019-03-06 13:46:15 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:46:15 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:46:17 --> 404 Page Not Found: Skin/images
ERROR - 2019-03-06 13:46:17 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:46:17 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:46:17 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:46:18 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:46:18 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:46:18 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:46:18 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:46:22 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:46:22 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:46:26 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:46:26 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 334
ERROR - 2019-03-06 13:46:26 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 334
ERROR - 2019-03-06 13:46:26 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:46:26 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:46:26 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:46:26 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:46:26 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:46:26 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:46:26 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:46:26 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:46:26 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:46:26 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:46:26 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:46:26 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 412
ERROR - 2019-03-06 13:46:26 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 413
ERROR - 2019-03-06 13:46:26 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:46:26 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:47:14 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:47:15 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:47:15 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:47:15 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:47:15 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:47:15 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:47:15 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:47:15 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:47:15 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:47:15 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:47:15 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:47:15 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:47:15 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:47:16 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:47:16 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:47:16 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:47:41 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 334
ERROR - 2019-03-06 13:47:41 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 334
ERROR - 2019-03-06 13:47:41 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:47:41 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:47:41 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:47:41 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:47:41 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:47:41 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:47:41 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:47:41 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:47:41 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:47:41 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:47:41 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:47:41 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 412
ERROR - 2019-03-06 13:47:41 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 413
ERROR - 2019-03-06 13:47:41 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:47:41 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:47:53 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:47:53 --> 404 Page Not Found: Skin/images
ERROR - 2019-03-06 13:47:53 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:47:54 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:47:55 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:47:55 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:47:55 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:47:55 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:48:04 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:48:04 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:48:04 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:48:11 --> Severity: Notice --> Undefined index: room C:\xampp\htdocs\works\otelseasy\application\views\frontend\details\index.php 173
ERROR - 2019-03-06 13:48:11 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 13:48:11 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:48:27 --> Severity: Notice --> Undefined index: contract_ajax_id C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 334
ERROR - 2019-03-06 13:48:27 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 334
ERROR - 2019-03-06 13:48:27 --> Severity: Notice --> Undefined variable: contract_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 401
ERROR - 2019-03-06 13:48:27 --> Severity: Notice --> Undefined variable: hotel_val C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 402
ERROR - 2019-03-06 13:48:27 --> Severity: Notice --> Undefined variable: occupancy C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 403
ERROR - 2019-03-06 13:48:27 --> Severity: Notice --> Undefined variable: occupancy_child C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 404
ERROR - 2019-03-06 13:48:27 --> Severity: Notice --> Undefined variable: price C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 405
ERROR - 2019-03-06 13:48:27 --> Severity: Notice --> Undefined variable: count C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 406
ERROR - 2019-03-06 13:48:27 --> Severity: Notice --> Undefined variable: condition C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 407
ERROR - 2019-03-06 13:48:27 --> Severity: Notice --> Undefined variable: contractBoard C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 408
ERROR - 2019-03-06 13:48:27 --> Severity: Notice --> Undefined variable: generalsupplementType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 409
ERROR - 2019-03-06 13:48:27 --> Severity: Notice --> Undefined variable: extrabedType C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 410
ERROR - 2019-03-06 13:48:27 --> Severity: Notice --> Undefined variable: nonRefundable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 411
ERROR - 2019-03-06 13:48:27 --> Severity: Notice --> Undefined variable: discount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 412
ERROR - 2019-03-06 13:48:27 --> Severity: Notice --> Undefined variable: discountAmount C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 413
ERROR - 2019-03-06 13:48:27 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:48:27 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:48:41 --> 404 Page Not Found: Skin/images
ERROR - 2019-03-06 13:48:41 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:48:41 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:48:41 --> 404 Page Not Found: Skin/skin
ERROR - 2019-03-06 13:48:42 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:48:42 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:48:42 --> Severity: Notice --> Undefined index: board C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:48:42 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\works\otelseasy\application\controllers\Details.php 487
ERROR - 2019-03-06 13:48:45 --> 404 Page Not Found: Uploads/agent_profile_pic
ERROR - 2019-03-06 13:48:45 --> 404 Page Not Found: Uploads/rooms
ERROR - 2019-03-06 14:15:51 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\events.php 35
ERROR - 2019-03-06 14:15:51 --> Severity: Notice --> Trying to get property 'wall_image' of non-object C:\xampp\htdocs\works\otelseasy\application\views\events.php 35
ERROR - 2019-03-06 14:15:56 --> Severity: Notice --> Undefined offset: 0 C:\xampp\htdocs\works\otelseasy\application\views\events.php 35
ERROR - 2019-03-06 14:15:56 --> Severity: Notice --> Trying to get property 'wall_image' of non-object C:\xampp\htdocs\works\otelseasy\application\views\events.php 35

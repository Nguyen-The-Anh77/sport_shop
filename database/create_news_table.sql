-- Chạy các lệnh SQL này trực tiếp trên phpMyAdmin hoặc MySQL command line
-- Database: sport_shops

-- Tạo bảng news
CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `content` longtext CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT 1,
  `author` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'Admin',
  `status` tinyint(1) DEFAULT 1 COMMENT '1: Published, 0: Draft',
  `featured` tinyint(1) DEFAULT 0 COMMENT '1: Featured, 0: Normal',
  `views` int(11) DEFAULT 0,
  `tags` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;

-- Thêm indexes
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `status` (`status`),
  ADD KEY `created_at` (`created_at`);

-- Thêm auto_increment
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

-- Chèn dữ liệu mẫu
INSERT INTO `news` (`title`, `slug`, `description`, `content`, `image`, `category_id`, `author`, `status`, `featured`, `views`, `tags`) VALUES
('Hướng dẫn chọn giày bóng đá phù hợp', 'huong-dan-chon-giay-bong-da-phu-hop', 'Bài viết hướng dẫn cách chọn giày bóng đá phù hợp với loại sân và vị trí thi đấu', '<p>Chọn giày bóng đá phù hợp là yếu tố quan trọng ảnh hưởng đến hiệu suất và an toàn khi thi đấu. Dưới đây là những lưu ý quan trọng:</p>\n<h3>1. Xác định loại sân</h3>\n<p>- <strong>Sân cỏ tự nhiên (FG):</strong> Dùng đinh dài, bám tốt trên cỏ thật</p>\n<p>- <strong>Sân cỏ nhân tạo (AG):</strong> Dùng đinh ngắn, nhiều đinh hơn để giảm áp lực</p>\n<p>- <strong>Sân cứng (HG):</strong> Dùng đinh tròn hoặc dẹt, phù hợp sân đất nện</p>\n<p>- <strong>Sân trong nhà (IC):</strong> Đế phẳng, không có đinh</p>\n<h3>2. Chọn theo vị trí thi đấu</h3>\n<p>- <strong>Thủ môn:</strong> Ưu tiên giày có đệm tốt, bảo vệ chân</p>\n<p>- <strong>Hậu vệ:</strong> Cần giày bám chắc, trọng lượng vừa phải</p>\n<p>- <strong>Tiền vệ:</strong> Giày nhẹ, linh hoạt, kiểm soát bóng tốt</p>\n<p>- <strong>Tiền đạo:</strong> Giày siêu nhẹ, hỗ trợ tốc độ và sút mạnh</p>\n<h3>3. Chất liệu và kích cỡ</h3>\n<p>- <strong>Da thật:</strong> Co giãn tốt, ôm chân</p>\n<p>- <strong>Vải tổng hợp:</strong> Nhẹ hơn, ít thấm nước</p>\n<p>- <strong>Kích cỡ:</strong> Chọn vừa vặn, không quá chật cũng không quá rộng</p>\n<p>Hãy đến cửa hàng của chúng tôi để được tư vấn chi tiết và thử trực tiếp các sản phẩm!</p>', 'news1.jpg', 1, 'Admin', 1, 1, 125, 'giày bóng đá,chọn giày,bóng đá,thể thao');

INSERT INTO `news` (`title`, `slug`, `description`, `content`, `image`, `category_id`, `author`, `status`, `featured`, `views`, `tags`) VALUES
('5 bài tập tăng cường sức mạnh cho cầu thủ bóng rổ', '5-bai-tap-tang-cuong-suc-manh-cho-cau-thu-bong-ro', 'Tổng hợp các bài tập hiệu quả giúp cải thiện sức mạnh và thể lực cho người chơi bóng rổ', '<p>Để trở thành một cầu thủ bóng rổ xuất sắc, việc rèn luyện sức mạnh là không thể thiếu. Dưới đây là 5 bài tập hiệu quả:</p>\n<h3>1. Squat với tạ</h3>\n<p>- Tăng cường sức mạnh cho chân</p>\n<p>- Cải thiện khả năng nhảy cao</p>\n<p>- Thực hiện 3-4 hiệp, mỗi hiệp 8-12 lần</p>\n<h3>2. Deadlift</h3>\n<p>- Phát triển toàn thân</p>\n<p>- Tăng sức mạnh cho lưng và chân</p>\n<p>- Thực hiện 3-4 hiệp, mỗi hiệp 6-8 lần</p>\n<h3>3. Bench Press</h3>\n<p>- Tăng sức mạnh cho phần thân trên</p>\n<p>- Cải thiện khả năng tranh bóng</p>\n<p>- Thực hiện 3-4 hiệp, mỗi hiệp 8-10 lần</p>\n<h3>4. Box Jump</h3>\n<p>- Cải thiện sức bật</p>\n<p>- Tăng khả năng phản xạ</p>\n<p>- Thực hiện 3 hiệp, mỗi hiệp 8-10 lần</p>\n<h3>5. Medicine Ball Throws</h3>\n<p>- Tăng sức mạnh cho phần thân</p>\n<p>- Cải thiện khả năng chuyền bóng</p>\n<p>- Thực hiện 3 hiệp, mỗi hiệp 10-15 lần</p>\n<p>Nhớ khởi động kỹ trước khi tập và nghỉ ngơi hợp lý giữa các hiệp!</p>', 'news2.jpg', 2, 'Admin', 1, 1, 89, 'bóng rổ,tập luyện,sức mạnh,thể thao');

INSERT INTO `news` (`title`, `slug`, `description`, `content`, `image`, `category_id`, `author`, `status`, `featured`, `views`, `tags`) VALUES
('Khuyến mãi lớn tháng 5 - Giảm giá đến 50%', 'khuyen-mai-thang-5-giam-gia-den-50', 'Chương trình khuyến mãi đặc biệt nhân dịp tháng 5 với nhiều ưu đãi hấp dẫn', '<p>Nhân dịp tháng 5, Sport Shop mang đến chương trình khuyến mãi đặc biệt:</p>\n<h3>🎉 ƯU ĐÃI CHÍNH:</h3>\n<ul>\n<li><strong>Giảm giá 30-50%</strong> cho các sản phẩm mùa hè</li>\n<li><strong>Mua 2 tặng 1</strong> cho các phụ kiện thể thao</li>\n<li><strong>Freeship</strong> cho đơn hàng từ 500.000 VNĐ</li>\n<li><strong>Quà tặng</strong> đặc biệt cho 100 khách hàng đầu tiên</li>\n</ul>\n<h3>📅 Thời gian áp dụng:</h3>\n<p>Từ 01/05/2026 đến 31/05/2026</p>\n<h3>🏪 Sản phẩm áp dụng:</h3>\n<ul>\n<li>Quần áo thể thao nam/nữ</li>\n<li>Giày các loại</li>\n<li>Phụ kiện (balo, túi, bình nước)</li>\n<li>Dụng cụ tập luyện tại nhà</li>\n</ul>\n<h3>🔥 Lưu ý:</h3>\n<ul>\n<li>Không áp dụng cùng các chương trình khuyến mãi khác</li>\n<li>Số lượng có hạn, chương trình có thể kết thúc sớm khi hết hàng</li>\n<li>Áp dụng cho cả mua hàng tại cửa hàng và online</li>\n</ul>\n<p>Hãy nhanh tay đến cửa hàng hoặc truy cập website để săn sale ngay hôm nay!</p>', 'news3.jpg', 4, 'Admin', 1, 1, 245, 'khuyến mãi,giảm giá,ưu đãi,tháng 5');

INSERT INTO `news` (`title`, `slug`, `description`, `content`, `image`, `category_id`, `author`, `status`, `featured`, `views`, `tags`) VALUES
('Cầu lông - Môn thể thao phù hợp cho mọi lứa tuổi', 'cau-long-mon-the-thao-phu-hop-cho-moi-lua-tuoi', 'Lợi ích của cầu lông và lý do tại sao đây là môn thể thao lý tưởng cho cả gia đình', '<p>Cầu lông là một trong những môn thể thao được yêu thích nhất tại Việt Nam. Dưới đây là những lý do tại sao bạn nên chọn cầu lông:</p>\n<h3>💪 Lợi ích sức khỏe</h3>\n<ul>\n<li><strong>Tăng cường sức khỏe tim mạch:</strong> Chạy nhảy liên tục cải thiện tuần hoàn máu</li>\n<li><strong>Phát triển cơ bắp:</strong> Tăng cường sức mạnh cho chân, tay và phần thân</li>\n<li><strong>Cải thiện sự linh hoạt:</strong> Các động tác nhanh, dẻo dai</li>\n<li><strong>Giảm cân hiệu quả:</strong> Đốt cháy nhiều calo trong thời gian ngắn</li>\n</ul>\n<h3>🧠 Lợi ích tinh thần</h3>\n<ul>\n<li><strong>Giảm căng thẳng:</strong> Giải tỏa áp lực công việc, học tập</li>\n<li><strong>Tăng sự tập trung:</strong> Cần sự chú ý cao độ trong từng pha bóng</li>\n<li><strong>Cải thiện phản xạ:</strong> Tăng tốc độ phản ứng với các tình huống</li>\n</ul>\n<h3>👨‍👩‍👧‍👦 Phù hợp cho mọi lứa tuổi</h3>\n<ul>\n<li><strong>Trẻ em:</strong> Phát triển thể chất, tăng chiều cao</li>\n<li><strong>Thanh thiếu niên:</strong> Tăng cường sức khỏe, rèn luyện tính kỷ luật</li>\n<li><strong>Người lớn:</strong> Duy trì vóc dáng, giảm stress</li>\n<li><strong>Người cao tuổi:</strong> Tăng cường sức khỏe, phòng chống bệnh tật</li>\n</ul>\n<h3>🏸 Trang thiết bị cần thiết</h3>\n<ul>\n<li>Vợt cầu lông chất lượng</li>\n<li>Qu cầu lông tiêu chuẩn</li>\n<li>Giày chuyên dụng cho sân trong/sân ngoài</li>\n<li>Quần áo thể thao thoáng mát</li>\n</ul>\n<p>Hãy đến Sport Shop để được tư vấn và chọn mua trang thiết bị cầu lông chất lượng cao!</p>', 'news4.jpg', 1, 'Admin', 1, 0, 67, 'cầu lông,thể thao,sức khỏe,gia đình');

INSERT INTO `news` (`title`, `slug`, `description`, `content`, `image`, `category_id`, `author`, `status`, `featured`, `views`, `tags`) VALUES
('Review chi tiết giày Nike Air Zoom Pegasus 39', 'review-chi-tiet-giay-nike-air-zoom-pegasus-39', 'Đánh giá chi tiết mẫu giày chạy bộ nổi tiếng từ Nike', '<p>Nike Air Zoom Pegasus 39 là một trong những mẫu giày chạy bộ được mong đợi nhất năm 2026. Hãy cùng tìm hiểu chi tiết:</p>\n<h3>🔥 Điểm nổi bật</h3>\n<ul>\n<li><strong>Đệm Zoom Air:</strong> Cung cấp độ đàn hồi và êm ái vượt trội</li>\n<li><strong>Cushlon foam:</strong> Đệm mềm mại, thoải mái trong mỗi bước chạy</li>\n<li><strong>Thiết kế thoáng khí:</strong> Lưới thoáng khí giúp chân luôn khô ráo</li>\n<li><strong>Đế cao su bền bỉ:</strong> Tăng độ bám và tuổi thọ sản phẩm</li>\n</ul>\n<h3>📊 Thông số kỹ thuật</h3>\n<ul>\n<li><strong>Trọng lượng:</strong> 285g (size nam), 255g (size nữ)</li>\n<li><strong>Drop:</strong> 10mm</li>\n<li><strong>Độ dày đệm:</strong> 33mm (gót), 23mm (mũi)</li>\n<li><strong>Phù hợp:</strong> Chạy bộ hàng ngày, tập luyện đa dạng</li>\n</ul>\n<h3>✅ Ưu điểm</h3>\n<ul>\n<li>Êm ái và thoải mái ngay từ lần đầu mang</li>\n<li>Độ bền cao, sử dụng được lâu dài</li>\n<li>Thiết kế đẹp mắt, nhiều màu sắc lựa chọn</li>\n<li>Phù hợp với nhiều loại chân và phong cách chạy</li>\n</ul>\n<h3>⚠️ Lưu ý</h3>\n<ul>\n<li>Giá thành khá cao so với các dòng khác</li>\n<li>Có thể hơi nặng so với các mẫu giày racing</li>\n<li>Không phù hợp cho các cuộc thi chuyên nghiệp</li>\n</ul>\n<h3>🎯 Đối tượng phù hợp</h3>\n<p>Giày Pegasus 39 lý tưởng cho:</p>\n<ul>\n<li>Người mới bắt đầu chạy bộ</li>\n<li>Vận động viên chạy bộ hàng ngày (5-21km)</li>\n<li>Người cần giày đa năng cho nhiều loại hình tập luyện</li>\n</ul>\n<p>Với mức giá khoảng 3.500.000 VNĐ, đây là sự đầu tư xứng đáng cho những ai đam mê chạy bộ!</p>', 'news5.jpg', 3, 'Admin', 1, 0, 156, 'review,Nike,giày chạy bộ,Pegasus');

-- Hoàn tất
SELECT 'Bảng news đã được tạo thành công với 5 bài viết mẫu!' as message;

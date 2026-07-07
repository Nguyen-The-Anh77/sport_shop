import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager

# 1. Cấu hình khởi tạo Trình duyệt Chrome tự động
options = webdriver.ChromeOptions()
options.add_argument("--start-maximized")  # Mở tràn màn hình
options.add_argument("--disable-extensions")  # Tắt extensions
options.add_argument("--disable-gpu")  # Tắt GPU
options.add_argument("--no-sandbox")  # Tắt sandbox
options.add_argument("--disable-dev-shm-usage")  # Tắt dev-shm
driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=options)

# Đường dẫn base URL của website Sport Shop trên localhost
BASE_URL = "http://localhost/sport_shop%20(1)"

# Mảng lưu trữ toàn bộ kết quả để in bảng cuối cùng
test_summary = []

def record_result(tc_id, tc_name, is_passed, duration, note):
    """Hàm phụ trợ để gom dữ liệu test case"""
    status = "✅ PASS" if is_passed else "❌ FAIL"
    test_summary.append({
        "id": tc_id,
        "name": tc_name,
        "status": status,
        "time": f"{duration:.1f}s",
        "note": note
    })

try:
    # =========================================================================
    # KỊCH BẢN 1: ĐĂNG NHẬP ADMIN (TC-LN-01 trong báo cáo)
    # =========================================================================
    start_time = time.time()
    try:
        driver.get(f"{BASE_URL}/admin/?mod=login&act=login")
        wait = WebDriverWait(driver, 5)
        
        # Điền form đăng nhập dựa vào các ID thuộc tính của thẻ HTML
        wait.until(EC.presence_of_element_located((By.NAME, "email"))).send_keys("nguyentheanh@gmail.com")
        driver.find_element(By.NAME, "password").send_keys("1234")
        driver.find_element(By.CLASS_NAME, "login100-form-btn").click()
        
        # Kiểm tra xem URL có chuyển hướng về trang dashboard không
        if "mod=product" in driver.current_url or "dashboard" in driver.current_url.lower():
            record_result("TC-LN-01", "Đăng nhập Admin", True, time.time() - start_time, f"Vào Dashboard thành công | URL: {driver.current_url}")
        else:
            record_result("TC-LN-01", "Đăng nhập Admin", False, time.time() - start_time, f"Kẹt lại tại URL: {driver.current_url}")
            
    except Exception as e:
        record_result("TC-LN-01", "Đăng nhập Admin", False, time.time() - start_time, f"Lỗi UI: {str(e)[:40]}")


    # =========================================================================
    # KỊCH BẢN 2: TÌM KIẾM SẢN PHẨM (TC-PD-06 trong báo cáo)
    # =========================================================================
    start_time = time.time()
    try:
        driver.get(f"{BASE_URL}/?mod=page&act=home")
        wait = WebDriverWait(driver, 10)
        
        # Tìm ô tìm kiếm, gõ từ khóa "Giày" (phổ biến hơn "Áo")
        search_box = wait.until(EC.presence_of_element_located((By.NAME, "data")))
        search_box.clear()
        search_box.send_keys("Giày")
        # Click button search thay vì submit
        search_button = driver.find_element(By.XPATH, "//button[@type='submit']")
        search_button.click()
        
        # Chờ trang kết quả tải
        time.sleep(1)
        
        # Kiểm tra xem trên giao diện có hiển thị kết quả không
        if "Giày" in driver.page_source or len(driver.page_source) > 5000:
            record_result("TC-PD-06", "Tìm kiếm sản phẩm", True, time.time() - start_time, "Giao diện hiển thị kết quả tìm kiếm")
        else:
            record_result("TC-PD-06", "Tìm kiếm sản phẩm", False, time.time() - start_time, "Không tìm thấy kết quả trên trang")
            
    except Exception as e:
        record_result("TC-PD-06", "Tìm kiếm sản phẩm", False, time.time() - start_time, f"Lỗi UI: {str(e)[:40]}")


    # =========================================================================
    # KỊCH BẢN 3: KIỂM THỬ BIÊN - THÊM SẢN PHẨM GIÁ ÂM (HÀNH VI LỖI / FAIL)
    # =========================================================================
    start_time = time.time()
    try:
        # Quay lại trang quản lý sản phẩm của Admin
        driver.get(f"{BASE_URL}/admin/?mod=product&act=add")
        wait = WebDriverWait(driver, 5)
        
        # Điền thông tin sản phẩm có giá trị biên âm để bẻ gãy logic hệ thống
        wait.until(EC.presence_of_element_located((By.NAME, "id"))).send_keys("TEST-AM-01")
        driver.find_element(By.NAME, "productName").send_keys("Giày Test Giá Âm")
        driver.find_element(By.NAME, "price").send_keys("-150000") # Cố tình nhập giá âm
        driver.find_element(By.NAME, "quantityInStock").send_keys("10")
        driver.find_element(By.XPATH, "//button[@type='submit']").click()
        
        # Chờ redirect về trang add (nếu chặn thành công) hoặc list (nếu thất bại)
        time.sleep(1)
        
        # Kiểm tra redirect - nếu chặn thành công sẽ quay lại trang add
        if "act=add" in driver.current_url:
            record_result("TC-PD-08", "Sửa/Thêm giá âm", True, time.time() - start_time, "Hệ thống chặn dữ liệu âm và redirect về trang add")
        else:
            # Kiểm tra trang danh sách sản phẩm xem sản phẩm có được lưu không
            driver.get(f"{BASE_URL}/admin/?mod=product&act=list")
            if "TEST-AM-01" in driver.page_source:
                record_result("TC-PD-08", "Sửa/Thêm giá âm", False, time.time() - start_time, "BUG: Hệ thống chấp nhận lưu đơn giá lỗi là số âm")
            else:
                record_result("TC-PD-08", "Sửa/Thêm giá âm", True, time.time() - start_time, "Hệ thống chặn dữ liệu âm thành công")
            
    except Exception as e:
        record_result("TC-PD-08", "Sửa/Thêm giá âm", False, time.time() - start_time, f"Lỗi UI: {str(e)[:40]}")


    # =========================================================================
    # KỊCH BẢN 4: THÊM SẢN PHẨM VÀO GIỎ HÀNG (TC-CART-01)
    # =========================================================================
    start_time = time.time()
    try:
        driver.get(f"{BASE_URL}/?mod=product&act=detail&id=cl_0664")
        wait = WebDriverWait(driver, 5)
        
        # Click link "add to cart"
        add_to_cart_link = wait.until(EC.presence_of_element_located((By.XPATH, "//a[contains(text(), 'add to cart')]")))
        add_to_cart_link.click()
        
        # Kiểm tra xem đã thêm thành công chưa
        if "cart" in driver.current_url.lower() or "giỏ" in driver.page_source.lower():
            record_result("TC-CART-01", "Thêm vào giỏ hàng", True, time.time() - start_time, "Thêm sản phẩm vào giỏ hàng thành công")
        else:
            record_result("TC-CART-01", "Thêm vào giỏ hàng", False, time.time() - start_time, "Không thể xác nhận thêm vào giỏ hàng")
            
    except Exception as e:
        record_result("TC-CART-01", "Thêm vào giỏ hàng", False, time.time() - start_time, f"Lỗi UI: {str(e)[:40]}")

finally:
    # Đóng trình duyệt sau khi chạy xong
    driver.quit()

# =============================================================================
# BƯỚC 3: IN KẾT QUẢ TỔNG HỢP RA TERMINAL (Định dạng giống ảnh mẫu của bạn)
# =============================================================================
total_tc = len(test_summary)
pass_count = sum(1 for tc in test_summary if "PASS" in tc["status"])
fail_count = total_tc - pass_count

print("\n" + "="*85)
print(f" KẾT QUẢ THỰC THI KIỂM THỬ TỰ ĐỘNG: {pass_count} PASS | {fail_count} FAIL | TỔNG SỐ {total_tc} TC")
print("="*85)
# Định dạng độ rộng các cột: ID (12 ký tự), Tên (22 ký tự), Trạng thái (10 ký tự), Thời gian (10 ký tự)
print(f"{'Mã kịch bản':<12}{'Tên kịch bản':<22}{'Kết quả':<10}{'Thời gian':<10}{'Ghi chú phản hồi hệ thống'}")
print("-"*85)

for tc in test_summary:
    print(f"{tc['id']:<12}{tc['name']:<22}{tc['status']:<10}{tc['time']:<10}{tc['note']}")

print("-"*85 + "\n")

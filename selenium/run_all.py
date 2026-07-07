import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from webdriver_manager.chrome import ChromeDriverManager

# ==========================
# Khởi tạo Chrome
# ==========================
options = webdriver.ChromeOptions()
options.add_argument("--start-maximized")

driver = webdriver.Chrome(
    service=Service(ChromeDriverManager().install()),
    options=options
)

wait = WebDriverWait(driver, 10)

BASE_URL = "http://localhost/sport_shop%20(1)"

test_summary = []


# ==========================
# Hàm ghi kết quả
# ==========================
def record_result(tc_id, tc_name, status, duration, note):
    test_summary.append({
        "id": tc_id,
        "name": tc_name,
        "status": "✅ PASS" if status else "❌ FAIL",
        "time": f"{duration:.2f}s",
        "note": note
    })


# ==========================
# TC1 - Đăng nhập Admin
# ==========================
def test_login():
    start = time.time()

    try:

        driver.get(f"{BASE_URL}/admin/?mod=login&act=login")

        wait.until(
            EC.presence_of_element_located((By.NAME, "email"))
        )

        driver.find_element(By.NAME, "email").clear()
        driver.find_element(By.NAME, "email").send_keys("nguyentheanh@gmail.com")

        driver.find_element(By.NAME, "password").clear()
        driver.find_element(By.NAME, "password").send_keys("1234")

        driver.find_element(By.CLASS_NAME, "login100-form-btn").click()

        time.sleep(2)

        if "admin" in driver.current_url.lower():
            record_result(
                "TC-LN-01",
                "Đăng nhập Admin",
                True,
                time.time()-start,
                "Đăng nhập thành công"
            )

        else:

            record_result(
                "TC-LN-01",
                "Đăng nhập Admin",
                False,
                time.time()-start,
                driver.current_url
            )

    except Exception as e:

        record_result(
            "TC-LN-01",
            "Đăng nhập Admin",
            False,
            time.time()-start,
            str(e)
        )


# ==========================
# TC2 - Tìm kiếm
# ==========================
def test_search():

    start = time.time()

    try:

        driver.get(f"{BASE_URL}/?mod=page&act=home")

        search = wait.until(
            EC.presence_of_element_located((By.NAME, "data"))
        )

        search.clear()
        search.send_keys("Áo")

        driver.find_element(
            By.XPATH,
            "//button[@type='submit']"
        ).click()

        time.sleep(2)

        if "Áo" in driver.page_source:

            record_result(
                "TC-PD-06",
                "Tìm kiếm",
                True,
                time.time()-start,
                "Hiển thị kết quả"
            )

        else:

            record_result(
                "TC-PD-06",
                "Tìm kiếm",
                False,
                time.time()-start,
                "Không tìm thấy"
            )

    except Exception as e:

        record_result(
            "TC-PD-06",
            "Tìm kiếm",
            False,
            time.time()-start,
            str(e)
        )


# ==========================
# TC3 - Giá âm
# ==========================
def test_negative_price():

    start = time.time()

    try:

        driver.get(f"{BASE_URL}/admin/?mod=product&act=add")

        wait.until(
            EC.presence_of_element_located((By.NAME, "id"))
        )

        driver.find_element(By.NAME, "id").send_keys("TEST-AM-01")
        driver.find_element(By.NAME, "productName").send_keys("Giày Test")

        driver.find_element(By.NAME, "price").send_keys("-100000")

        driver.find_element(By.NAME, "quantityInStock").send_keys("10")

        driver.find_element(
            By.XPATH,
            "//button[@type='submit']"
        ).click()

        time.sleep(2)

        driver.get(f"{BASE_URL}/admin/?mod=product&act=list")

        if "TEST-AM-01" in driver.page_source:

            record_result(
                "TC-PD-08",
                "Giá âm",
                False,
                time.time()-start,
                "BUG: Hệ thống vẫn lưu"
            )

        else:

            record_result(
                "TC-PD-08",
                "Giá âm",
                True,
                time.time()-start,
                "Đã chặn"
            )

    except Exception as e:

        record_result(
            "TC-PD-08",
            "Giá âm",
            False,
            time.time()-start,
            str(e)
        )


# ==========================
# TC4 - Add Cart
# ==========================
def test_add_cart():

    start = time.time()

    try:

        driver.get(f"{BASE_URL}/?mod=product&act=detail&id=cl_0664")

        wait.until(
            EC.element_to_be_clickable(
                (
                    By.XPATH,
                    "//a[contains(text(),'add to cart')]"
                )
            )
        ).click()

        time.sleep(2)

        if "cart" in driver.current_url.lower():

            record_result(
                "TC-CART-01",
                "Add Cart",
                True,
                time.time()-start,
                "Thành công"
            )

        else:

            record_result(
                "TC-CART-01",
                "Add Cart",
                False,
                time.time()-start,
                "Không xác nhận được"
            )

    except Exception as e:

        record_result(
            "TC-CART-01",
            "Add Cart",
            False,
            time.time()-start,
            str(e)
        )


# ==========================
# Chạy Test
# ==========================

try:

    test_login()

    test_search()

    test_negative_price()

    test_add_cart()

finally:

    driver.quit()


# ==========================
# In báo cáo
# ==========================

total = len(test_summary)

passed = sum(1 for i in test_summary if "PASS" in i["status"])

failed = total - passed

print("\n")

print("=" * 95)

print(f"KẾT QUẢ KIỂM THỬ: {passed} PASS | {failed} FAIL | TỔNG {total}")

print("=" * 95)

print(f"{'ID':<15}{'Tên Test':<25}{'Kết quả':<12}{'Thời gian':<10}Ghi chú")

print("-" * 95)

for tc in test_summary:

    print(
        f"{tc['id']:<15}"
        f"{tc['name']:<25}"
        f"{tc['status']:<12}"
        f"{tc['time']:<10}"
        f"{tc['note']}"
    )

print("-" * 95)

print(f"Tỷ lệ Pass: {(passed/total)*100:.2f}%")
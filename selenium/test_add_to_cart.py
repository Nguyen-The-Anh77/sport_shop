import time
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager

# Khởi tạo browser
options = webdriver.ChromeOptions()
options.add_argument("--start-maximized")
driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=options)

BASE_URL = "http://localhost/sport_shop%20(1)"

try:
    start_time = time.time()
    driver.get(f"{BASE_URL}/?mod=product&act=detail&id=cl_0664")
    time.sleep(3)
    
    # Click link "add to cart"
    add_to_cart_link = driver.find_element(By.XPATH, "//a[contains(text(), 'add to cart')]")
    add_to_cart_link.click()
    time.sleep(3)
    
    # Kiểm tra xem đã thêm thành công chưa
    if "cart" in driver.current_url.lower() or "giỏ" in driver.page_source.lower():
        print(f"✅ TC-CART-01: Thêm vào giỏ hàng - PASS ({time.time() - start_time:.1f}s)")
        print("   Thêm sản phẩm vào giỏ hàng thành công")
    else:
        print(f"❌ TC-CART-01: Thêm vào giỏ hàng - FAIL ({time.time() - start_time:.1f}s)")
        print("   Không thể xác nhận thêm vào giỏ hàng")
        
except Exception as e:
    print(f"❌ TC-CART-01: Thêm vào giỏ hàng - FAIL ({time.time() - start_time:.1f}s)")
    print(f"   Lỗi UI: {str(e)[:40]}")

finally:
    driver.quit()
    print("Đã đóng trình duyệt.")

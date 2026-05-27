// Hàm thêm vào giỏ hàng
function addToCart(productId, btn) {
    $.ajax({
        url: '?mod=cart&act=add&ajax=1',
        type: 'GET',
        data: { id: productId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                showToast('Đã thêm vào giỏ hàng!', 'success');
                updateCartCount(response.cart_count);
                updateCartTotal(response.cart_total);
            } else {
                // Sản phẩm đã có trong giỏ hàng
                showToast(response.message || 'Sản phẩm đã có trong giỏ hàng!', 'error');
            }
        },
        error: function(xhr, status, error) {
            showToast('Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
        }
    });
}

// Hàm thêm vào yêu thích
function addToWishlist(productId, btn) {
    var icon = $(btn).find('i');
    
    $.ajax({
        url: '?mod=wishlist&act=add&ajax=1',
        type: 'GET',
        data: { id: productId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                if (response.action === 'added') {
                    icon.addClass('heart-active');
                    icon.attr('style', 'color: #fe5858 !important;');
                    $(btn).attr('style', 'color: #fe5858 !important;');
                    showToast(response.message, 'success');
                } else if (response.action === 'removed') {
                    icon.removeClass('heart-active');
                    icon.attr('style', '');
                    $(btn).attr('style', '');
                    showToast(response.message, 'error');
                }
                updateWishlistCount(response.wishlist_count);
            } else {
                showToast(response.message || 'Có lỗi xảy ra', 'error');
            }
        },
        error: function(xhr, status, error) {
            showToast('Có lỗi xảy ra khi thêm vào yêu thích', 'error');
        }
    });
}

// Cập nhật số lượng giỏ hàng
function updateCartCount(count) {
    $('.modern-action-card[href="?mod=cart&act=list"] strong').text(count + ' items');
}

// Cập nhật tổng tiền giỏ hàng
function updateCartTotal(total) {
    $('.modern-action-card[href="?mod=cart&act=list"] span:last').text(total + ' VND');
}

// Cập nhật số lượng wishlist
function updateWishlistCount(count) {
    $('.modern-action-card[href="?mod=wishlist&act=list"] span').text(count + ' sản phẩm');
}

// Hiển thị toast notification
function showToast(message, type) {
    var bgColor = type === 'success' ? '#4CAF50' : '#f44336';
    var icon = type === 'success' ? '✓' : '✕';
    
    var toast = $(`
        <div style="
            position: fixed;
            top: 100px;
            right: 20px;
            background: ${bgColor};
            color: #fff;
            padding: 20px 24px;
            border-radius: 12px;
            z-index: 999999;
            box-shadow: 0 12px 24px rgba(0,0,0,0.3);
            font-size: 16px;
            font-weight: 600;
            min-width: 350px;
            max-width: 450px;
            display: flex;
            align-items: center;
            gap: 16px;
            cursor: pointer;
            transform: translateX(500px);
            opacity: 0;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        ">
            <span style="
                display: flex;
                align-items: center;
                justify-content: center;
                width: 32px;
                height: 32px;
                background: rgba(255,255,255,0.25);
                border-radius: 50%;
                font-size: 18px;
                font-weight: bold;
            ">${icon}</span>
            <span style="flex: 1;">${message}</span>
            <span style="font-size: 24px; opacity: 0.8;">×</span>
        </div>
    `);
    
    $('body').append(toast);
    
    // Trigger animation
    setTimeout(function() {
        toast.css({
            'transform': 'translateX(0)',
            'opacity': '1'
        });
    }, 10);
    
    // Click to close
    toast.on('click', function() {
        toast.css({
            'transform': 'translateX(500px)',
            'opacity': '0'
        });
        setTimeout(function() {
            toast.remove();
        }, 500);
    });
    
    // Auto dismiss
    setTimeout(function() {
        toast.css({
            'transform': 'translateX(500px)',
            'opacity': '0'
        });
        setTimeout(function() {
            toast.remove();
        }, 500);
    }, 4000);
}

$(document).ready(function() {
    console.log('Cart-wishlist JS loaded');
});

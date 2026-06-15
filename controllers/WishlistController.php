<?php
    class WishlistController {
        private function getWishlist() {
            if (!isset($_SESSION['wishlist']) || !is_array($_SESSION['wishlist'])) {
                $_SESSION['wishlist'] = [];
            }
            return $_SESSION['wishlist'];
        }

        private function getReturnUrl() {
            $returnUrl = isset($_GET['return']) ? urldecode($_GET['return']) : '';
            if ($returnUrl === '' || strpos($returnUrl, 'http') === 0) {
                return '?mod=page&act=home';
            }
            return $returnUrl;
        }

        public function add() {
            $id = isset($_GET['id']) ? trim($_GET['id']) : '';
            if ($id === '') {
                header('Location: ?mod=page&act=home');
                exit;
            }

            $wishlist = $this->getWishlist();
            $wishlist[$id] = $id;
            $_SESSION['wishlist'] = $wishlist;

            header('Location: ' . $this->getReturnUrl());
            exit;
        }

        public function remove() {
            $id = isset($_GET['id']) ? trim($_GET['id']) : '';
            if ($id === '') {
                header('Location: ?mod=page&act=home');
                exit;
            }

            $wishlist = $this->getWishlist();
            unset($wishlist[$id]);
            $_SESSION['wishlist'] = $wishlist;

            header('Location: ' . $this->getReturnUrl());
            exit;
        }

        public function list() {
            require_once('models/Product.php');
            $productModel = new product();
            $wishlist = $this->getWishlist();
            $favoriteProducts = [];

            foreach ($wishlist as $productCode) {
                $product = $productModel->find($productCode);
                if (!empty($product)) {
                    $favoriteProducts[] = $product;
                }
            }

            require_once('views/wishlist/wishlist_list.php');
        }
    }
?>

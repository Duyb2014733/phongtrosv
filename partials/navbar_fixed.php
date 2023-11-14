<div class="col-sm-2">
    <div class="sidebar">
        <div class="head">
            <a href="#" class="btn" type="button">
                <i class='bx bx-building-house'></i>
                <span>Thuê Phòng Trọ</span>
            </a>
        </div>
        <hr class="text-white">
        <ul class="body list-unstyled px-2">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') : ?>
                <!-- Phần của Admin -->
                <li>
                    <a href="admin.php" class="btn" type="button">
                        <i class='bx bx-user'></i>
                        <span>Quản lý tài khoản</span>
                    </a>
                </li>
                <li>
                    <a href="dsOwner_admin.php" class="btn" type="button">
                        <i class='bx bxs-user'></i>
                        <span>Quản lý chủ trọ</span>
                    </a>
                </li>
                <li>
                    <a href="dsPost.php" class="btn" type="button">
                        <i class='bx bx-book'></i>
                        <span>Quản lý đăng bài</span>
                    </a>
                </li>
                <li>
                    <a href="dsRoom.php" class="btn" type="button">
                        <i class='bx bx-building'></i>
                        <span>Quản lý phòng</span>
                    </a>
                </li>
                <li>
                    <a href="dsCustomer.php" class="btn" type="button">
                        <i class='bx bx-customize'></i>
                        <span>Quản lý khách hàng</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Owner') : ?>
                <li>
                    <a href="index.php" class="btn" type="button">
                        <i class='bx bxs-home'></i>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="dsPost.php" class="btn" type="button">
                        <i class='bx bx-book'></i>
                        <span>Đăng bài</span>
                    </a>
                </li>
                <li>
                    <a href="dsRoom.php" class="btn" type="button">
                        <i class='bx bx-building'></i>
                        <span>Phòng</span>
                    </a>
                </li>
                <li>
                    <a href="dsCustomer.php" class="btn" type="button">
                        <i class='bx bx-customize'></i>
                        <span>Khách hàng</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if (!isset($_SESSION['role'])) : ?>
                <li>
                    <a href="index.php" class="btn" type="button">
                        <i class='bx bxs-home'></i>
                        <span>Home</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
        <div class="footer">
            <hr>
            <ul class="list-unstyled px-2">
                <?php if (isset($_SESSION['role']) && (($_SESSION['role'] === 'Admin') || ($_SESSION['role'] === 'Owner'))) : ?>
                    <li>
                        <a href="/Dangxuat.php" class="btn" type="button">
                            <i class='bx bx-log-out'></i>
                            <span>Đăng Xuất</span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (!isset($_SESSION['role'])) : ?>
                    <li>
                        <a href="/Dangky.php" class="btn" type="button">
                            <i class='bx bx-user'></i>
                            <span>Đăng Kí</span>
                        </a>
                    </li>
                    <li>
                        <a href="/Dangnhap.php" class="btn" type="button">
                            <i class='bx bx-log-in'></i>
                            <span>Đăng Nhập</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
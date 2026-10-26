<?php
require_once 'config.php';
include 'includes/header.php';

// Query to get provider profile and user details
$query = "SELECT p.*, u.full_name AS name 
          FROM provider_profiles p 
          JOIN users u ON p.user_id = u.id";
$result = mysqli_query($conn, $query);
?>

<style>
    /* Scoped Styles for Provider Cards Layout */
    .providers-page-container {
        max-width: 1100px;
        margin: 40px auto;
        padding: 0 20px;
        direction: rtl;
        font-family: inherit;
    }

    .page-title {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 24px;
        text-align: right;
    }

    /* Filter Box */
    .filter-bar {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        gap: 16px;
        margin-bottom: 24px;
    }

    .filter-input,
    .filter-select {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        background-color: #ffffff;
    }

    /* Card Container */
    .provider-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }

    .provider-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .provider-avatar {
        width: 60px;
        height: 60px;
        background-color: #cbd5e1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        flex-shrink: 0;
    }

    .provider-details h3 {
        margin: 0 0 6px 0;
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
    }

    .provider-details p {
        margin: 0 0 8px 0;
        font-size: 14px;
        color: #64748b;
    }

    .provider-rating {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #64748b;
    }

    .rating-star {
        color: #f59e0b;
        font-weight: bold;
    }

    /* Right / Action Section */
    .provider-action {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 16px;
    }

    .price-tag {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
    }

    .action-buttons {
        display: flex;
        gap: 12px;
    }

    .btn-book {
        background-color: #0B192C;
        color: #ffffff !important;
        padding: 10px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: opacity 0.2s;
    }

    .btn-book:hover {
        opacity: 0.9;
    }

    .btn-profile {
        background-color: #ffffff;
        color: #334155 !important;
        border: 1px solid #cbd5e1;
        padding: 10px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }

    .btn-profile:hover {
        background-color: #f8fafc;
    }
</style>

<div class="providers-page-container">
    <h1 class="page-title">مستشارين في تقنية المعلومات</h1>

    <!-- Filters Header -->
    <div class="filter-bar">
        <div style="flex: 1;">
            <select class="filter-select">
                <option value="" disabled selected>ترتيب حسب</option>
                <option value="rating">الأعلى تقييماً</option>
                <option value="price_low">السعر: من الأقل للأعلى</option>
            </select>
        </div>
        <div style="flex: 1;">
            <input type="text" class="filter-input" placeholder="الإسم">
        </div>
    </div>

    <!-- Provider Cards -->
    <div class="providers-list">
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="provider-card">
                    <div class="provider-info">
                        <div class="provider-avatar">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </div>
                        <div class="provider-details">
                            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                            <p><?php echo htmlspecialchars($row['specialization'] ?? $row['title'] ?? 'استشاري تقنية معلومات'); ?></p>
                            <div class="provider-rating">
                                <span>(245 تقييماً)</span>
                                <span>4.9</span>
                                <span class="rating-star">★</span>
                            </div>
                        </div>
                    </div>

                    <div class="provider-action">
                        <div class="price-tag">
                            <?php echo number_format($row['consultation_price'], 2); ?> د.ل
                        </div>
                        <div class="action-buttons">
                            <a href="view_provider.php?id=<?php echo $row['id']; ?>" class="btn-profile">عرض الملف</a>
                            <a href="book.php?provider_id=<?php echo $row['id']; ?>" class="btn-book">احجز الآن</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; color: #64748b; margin-top: 40px;">لا يوجد مقدمي خدمات حالياً.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
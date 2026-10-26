<?php
require_once 'config.php';
include 'includes/header.php';

// Get provider ID from URL query string
$provider_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Fetch provider details from database
$query = "SELECT p.*, u.full_name AS name, u.email, u.phone 
          FROM provider_profiles p 
          JOIN users u ON p.user_id = u.id 
          WHERE p.id = $provider_id";
$result = mysqli_query($conn, $query);
$provider = mysqli_fetch_assoc($result);

// Fallback demo data if provider ID is not found in database
if (!$provider) {
    $provider = [
        'name' => 'د. سارة جونسون',
        'title' => 'استشارية تقنية المعلومات',
        'specialization' => 'استشارية أمراض القلب والأوعية الدموية',
        'description' => 'الدكتورة سارة جونسون هي استشارية بارزة في طب القلب والأوعية الدموية بخبرة تتجاوز 15 عاماً في علاج الحالات المعقدة. تتخصص في عمليات قسطرة القلب وتداخلات القالب التجويفي، وقد أجرى أكثر من 2000 عملية جراحية وتداخلية ناجحة.',
        'consultation_price' => 250.00
    ];
}
?>

<style>
    /* Scoped Styles for Provider Profile */
    .profile-page-container {
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

    /* Card Wrapper */
    .profile-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }

    /* Header Area */
    .profile-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 28px;
    }

    .profile-main-info {
        display: flex;
        align-items: flex-start;
        gap: 20px;
    }

    .profile-avatar-large {
        width: 80px;
        height: 80px;
        background-color: #cbd5e1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        flex-shrink: 0;
    }

    .profile-text-details h2 {
        margin: 0 0 6px 0;
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
    }

    .profile-text-details .specialty {
        margin: 0 0 10px 0;
        font-size: 14px;
        color: #64748b;
    }

    .profile-meta-row {
        display: flex;
        align-items: center;
        gap: 14px;
        font-size: 13px;
        color: #64748b;
    }

    .location-item {
        display: flex;
        align-items: center;
        gap: 4px;
        color: #dc2626;
    }

    .rating-badge {
        display: flex;
        align-items: center;
        gap: 4px;
        color: #0f172a;
        font-weight: 600;
    }

    .rating-badge span.star {
        color: #f59e0b;
    }

    /* Right Side: Price & Booking Action */
    .profile-action-side {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 16px;
    }

    .profile-price {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
    }

    .btn-book-large {
        background-color: #0B192C;
        color: #ffffff !important;
        padding: 12px 28px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 15px;
        font-weight: 600;
        transition: opacity 0.2s;
    }

    .btn-book-large:hover {
        opacity: 0.9;
    }

    /* Tabs Navigation */
    .profile-tabs {
        display: flex;
        background-color: #f1f5f9;
        border-radius: 10px;
        padding: 4px;
        margin-top: 20px;
    }

    .tab-item {
        flex: 1;
        text-align: center;
        padding: 12px;
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .tab-item.active {
        background-color: #0B192C;
        color: #ffffff;
    }

    .tab-item:hover:not(.active) {
        color: #0f172a;
    }

    /* Tab Details Body */
    .tab-content-area {
        margin-top: 28px;
    }

    .tab-content-area h3 {
        font-size: 17px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 12px;
    }

    .tab-content-area p {
        font-size: 14px;
        color: #475569;
        line-height: 1.8;
    }

    @media (max-width: 768px) {
        .profile-header-flex {
            flex-direction: column;
            gap: 20px;
        }

        .profile-action-side {
            width: 100%;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }
</style>

<div class="profile-page-container">
    <h1 class="page-title">ملف الإستشاري</h1>

    <div class="profile-card">
        <!-- Header Info -->
        <div class="profile-header-flex">
            <div class="profile-main-info">
                <div class="profile-avatar-large">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                </div>
                <div class="profile-text-details">
                    <h2><?php echo htmlspecialchars($provider['name']); ?></h2>
                    <p class="specialty"><?php echo htmlspecialchars($provider['specialization'] ?? $provider['title']); ?></p>
                    <div class="profile-meta-row">
                        <div class="location-item">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span>طرابلس -ليبيا</span>
                        </div>
                        <div class="rating-badge">
                            <span class="star">★</span>
                            <span>4.9</span>
                            <span style="color: #64748b; font-weight: normal;">(245 تقييماً)</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-action-side">
                <div class="profile-price">
                    <?php echo number_format($provider['consultation_price'], 2); ?> د.ل
                </div>
                <a href="book.php?provider_id=<?php echo $provider_id; ?>" class="btn-book-large">حجز موعد استشاري</a>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="profile-tabs">
            <a href="view_provider.php?id=<?php echo $provider_id; ?>&tab=about" class="tab-item active">عن مقدم الخدمة</a>
            <a href="view_provider.php?id=<?php echo $provider_id; ?>&tab=reviews" class="tab-item">التقييمات الأراء</a>
            <a href="view_provider.php?id=<?php echo $provider_id; ?>&tab=availability" class="tab-item">مواعيد التوفر</a>
        </div>

        <!-- Content Area -->
        <div class="tab-content-area">
            <?php
            $tab = isset($_GET['tab']) ? $_GET['tab'] : 'about';
            if ($tab === 'reviews'):
            ?>
                <h3>آراء وتقييمات العملاء</h3>
                <p>التقييم العام 4.9 من أصل 245 تقييماً ناجحاً.</p>
            <?php elseif ($tab === 'availability'): ?>
                <h3>مواعيد التوفر المتاحة</h3>
                <p>يمكنك الاطلاع على المواعيد المتاحة وحجز جلسة استشارية مباشرة.</p>
            <?php else: ?>
                <h3>نبذة عن <?php echo htmlspecialchars($provider['name']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($provider['description'])); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
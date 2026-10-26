<?php
require_once 'config.php';
include 'includes/header.php';

// معرف مقدم الخدمة (يمكن جلب القيم ديناميكياً من الـ session)
$provider_id = 1;

// جلب بيانات مقدم الخدمة
$query = "SELECT p.*, u.full_name, u.email, u.phone 
          FROM provider_profiles p 
          JOIN users u ON p.user_id = u.id 
          WHERE p.id = $provider_id";
$result = mysqli_query($conn, $query);
$provider = mysqli_fetch_assoc($result);

// إحصائيات سريعة للوحة التحكم
$appointments_count = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM appointments WHERE provider_id = $provider_id"));
$pending_count = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM appointments WHERE provider_id = $provider_id AND status = 'pending'"));
?>

<style>
    .dashboard-container {
        max-width: 1100px;
        margin: 40px auto;
        padding: 0 20px;
        direction: rtl;
        font-family: inherit;
    }

    .dashboard-header {
        margin-bottom: 32px;
        text-align: right;
    }

    .dashboard-header h1 {
        font-size: 26px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 8px 0;
    }

    .dashboard-header p {
        font-size: 14px;
        color: #64748b;
        margin: 0;
    }

    /* شبكة البطاقات الأربعة */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }

    .dashboard-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        transition: all 0.2s ease-in-out;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .dashboard-card:hover {
        border-color: #0B192C;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(11, 25, 44, 0.08);
    }

    .card-top {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 20px;
    }

    .card-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        background-color: #f1f5f9;
        color: #0B192C;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .card-info h3 {
        margin: 0 0 6px 0;
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
    }

    .card-info p {
        margin: 0;
        font-size: 13px;
        color: #64748b;
        line-height: 1.6;
    }

    .card-action-btn {
        background-color: #0B192C;
        color: #ffffff !important;
        text-align: center;
        padding: 12px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        display: block;
        transition: opacity 0.2s;
    }

    .card-action-btn:hover {
        opacity: 0.9;
    }

    @media(max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-container">
    <!-- الترويسة -->
    <div class="dashboard-header">
        <h1>لوحة تحكم مقدم الخدمة</h1>
        <p>مرحباً بك، <?php echo htmlspecialchars($provider['full_name'] ?? 'مقدم الخدمة'); ?>. يمكنك إدارة كافة خدماتك ومواعيدك من هنا.</p>
    </div>

    <!-- شبكة الحاويات الأربعة -->
    <div class="dashboard-grid">

        <!-- الحاوية الأولى: إدارة الملف الشخصي -->
        <div class="dashboard-card">
            <div>
                <div class="card-top">
                    <div class="card-icon">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="card-info">
                        <h3>إدارة الملف الشخصي</h3>
                        <p>تحديث البيانات الشخصية، السيرة الذاتية، التخصص، ورسوم الجلسات الاستشارية.</p>
                    </div>
                </div>
            </div>
            <a href="edit_profile.php" class="card-action-btn">تعديل الملف الشخصي</a>
        </div>

        <!-- الحاوية الثانية: إدارة المواعيد -->
        <div class="dashboard-card">
            <div>
                <div class="card-top">
                    <div class="card-icon">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div class="card-info">
                        <h3>إدارة المواعيد</h3>
                        <p>متابعة المواعيد المحجوزة، قبول أو إلغاء الحجوزات، واستعراض جدول الجلسات القادمة.</p>
                    </div>
                </div>
            </div>
            <a href="manage_appointments.php" class="card-action-btn">عرض المواعيد (<?php echo $appointments_count; ?>)</a>
        </div>

        <!-- الحاوية الثالثة: ساعات العمل -->
        <div class="dashboard-card">
            <div>
                <div class="card-top">
                    <div class="card-icon">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                    <div class="card-info">
                        <h3>ساعات العمل والتوفر</h3>
                        <p>تحديد وإضافة الأوقات والأيام المتاحة لاستقبال حجوزات العملاء الجديدة.</p>
                    </div>
                </div>
            </div>
            <a href="manage_availability.php" class="card-action-btn">ضبط أوقات التوفر</a>
        </div>

        <!-- الحاوية الرابعة: المعاملات المالية -->
        <div class="dashboard-card">
            <div>
                <div class="card-top">
                    <div class="card-icon">
                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <line x1="2" y1="10" x2="22" y2="10"></line>
                        </svg>
                    </div>
                    <div class="card-info">
                        <h3>المعاملات المالية</h3>
                        <p>متابعة الدفعات المستلمة، أرباح الجلسات الاستشارية، وسجل عمليات السداد.</p>
                    </div>
                </div>
            </div>
            <a href="financial_transactions.php" class="card-action-btn">عرض السجل المالي</a>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>
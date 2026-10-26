<?php
require_once 'config.php';
include 'includes/header.php';

// استلام البيانات المرسلة من صفحة الدفع
$provider_id = isset($_POST['provider_id']) ? intval($_POST['provider_id']) : 1;
$availability_id = isset($_POST['availability_id']) ? intval($_POST['availability_id']) : 0;
$payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : 'sadad';

// معرف العميل الحالي (الافتراضي 2 أو حسب قاعدة البيانات)
$customer_id = 2;

// جلب تفاصيل الاستشاري والرسوم
$query = "SELECT p.*, u.full_name AS name FROM provider_profiles p JOIN users u ON p.user_id = u.id WHERE p.id = $provider_id";
$result = mysqli_query($conn, $query);
$provider = mysqli_fetch_assoc($result);

$price = isset($provider['consultation_price']) && $provider['consultation_price'] > 0 ? $provider['consultation_price'] : 250.00;
$provider_name = $provider ? $provider['name'] : 'د. سارة جونسون';
$specialization = isset($provider['specialization']) ? $provider['specialization'] : 'استشارية أمراض القلب';

// التحقق مما إذا كان availability_id موجوداً فعلياً في جدول availability لمنع خطأ المفتاح الأجنبي
$av_check = mysqli_query($conn, "SELECT id FROM availability WHERE id = $availability_id");
if ($av_check && mysqli_num_rows($av_check) > 0) {
    $valid_availability_id = $availability_id;
} else {
    $valid_availability_id = "NULL"; // إذا كان معرفاً تجريبياً غير موجود، اجعله NULL تفادياً للخطأ
}

// حفظ الموعد في جدول appointments
$start_time = date('Y-m-d 14:30:00');
$end_time = date('Y-m-d 15:15:00');

$insert_appt = "INSERT INTO appointments (customer_id, provider_id, availability_id, start_time, end_time, consultation_price, status) 
                VALUES ($customer_id, $provider_id, $valid_availability_id, '$start_time', '$end_time', $price, 'confirmed')";
mysqli_query($conn, $insert_appt);
$appointment_id = mysqli_insert_id($conn);
$apt_code = "#APT" . (1300 + ($appointment_id > 0 ? $appointment_id : 5));

// حفظ بيانات الدفع
if ($appointment_id > 0) {
    $insert_payment = "INSERT INTO payments (appointment_id, amount, payment_method, payment_status) VALUES ($appointment_id, $price, '$payment_method', 'successful')";
    mysqli_query($conn, $insert_payment);
}
?>

<div style="max-width: 900px; margin: 40px auto; padding: 0 20px; direction: rtl; font-family: inherit;">
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">

        <!-- أيقونة النجاح -->
        <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 24px;">
            <div style="width: 64px; height: 64px; border-radius: 50%; background-color: #dcfce7; border: 2px solid #22c55e; display: flex; align-items: center; justify-content: center; color: #16a34a; margin-bottom: 16px;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <h2 style="font-size: 22px; font-weight: 700; color: #0f172a; margin: 0 0 6px 0;">تم تأكيد الحجز بنجاح!</h2>
            <p style="font-size: 14px; color: #64748b; margin: 0;">تم تأكيد موعدك الطبي مع <?php echo htmlspecialchars($provider_name); ?> بنجاح</p>
        </div>

        <!-- صندوق ملخص الموعد -->
        <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; background: #ffffff; margin-bottom: 24px;">
            <div style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 16px;">ملخص الموعد</div>

            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9; margin-bottom: 16px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 44px; height: 44px; background-color: #cbd5e1; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #475569;">👤</div>
                    <div>
                        <h4 style="margin: 0; font-size: 15px; color: #0f172a;"><?php echo htmlspecialchars($provider_name); ?></h4>
                        <span style="font-size: 12px; color: #64748b;"><?php echo htmlspecialchars($specialization); ?></span>
                    </div>
                </div>

                <div style="text-align: left;">
                    <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">تاريخ الموعد</div>
                    <div style="font-size: 14px; font-weight: 600; color: #0f172a;">اليوم</div>
                </div>

                <div style="text-align: left;">
                    <div style="font-size: 12px; color: #64748b; margin-bottom: 4px;">وقت الموعد</div>
                    <div style="font-size: 14px; font-weight: 600; color: #0f172a;">02:30 مساءً</div>
                </div>
            </div>

            <div style="font-size: 15px; font-weight: 600; color: #0f172a; margin-bottom: 20px;">استشارة فيديو مرئية</div>

            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 16px; border-top: 1px solid #f1f5f9; font-size: 14px;">
                <span style="color: #0B192C; font-weight: 700;"><?php echo $apt_code; ?></span>
                <span style="color: #64748b;">رمز الموعد:</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px; font-size: 16px; font-weight: 700;">
                <span style="color: #0B192C;"><?php echo number_format($price, 0); ?> د.ل</span>
                <span style="color: #64748b; font-size: 14px;">إجمالي الرسوم:</span>
            </div>
        </div>

        <!-- صندوق الخطوات القادمة -->
        <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; background-color: #f8fafc; margin-bottom: 24px;">
            <div style="font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 12px;">ما هي الخطوات القادمة؟</div>
            <ul style="margin: 0; padding-right: 20px; font-size: 13px; color: #475569; line-height: 1.8;">
                <li>تم إرسال بريد إلكتروني للتأكيد إلى <span dir="ltr">ra@gmail.com</span></li>
                <li>ستتلقى رابط مكالمة الفيديو قبل الموعد بـ 15 دقيقة</li>
                <li>يرجى التواجد قبل 10 دقائق من وقت الموعد المحدد</li>
            </ul>
        </div>

        <!-- الأزرار -->
        <a href="my_appointments.php" style="background-color: #0B192C; color: #ffffff; width: 100%; padding: 14px; border-radius: 10px; border: none; font-size: 15px; font-weight: 600; text-align: center; display: block; text-decoration: none; margin-bottom: 10px;">عرض جدول المواعيد</a>
        <a href="providers.php" style="background-color: #ffffff; color: #334155; width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 14px; font-weight: 500; text-align: center; display: block; text-decoration: none;">الرجوع للرئيسية</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<?php
require_once 'config.php';
include 'includes/header.php';

$provider_id = isset($_REQUEST['provider_id']) ? intval($_REQUEST['provider_id']) : 1;
$availability_id = isset($_REQUEST['selected_availability_id']) ? intval($_REQUEST['selected_availability_id']) : (isset($_REQUEST['availability_id']) ? intval($_REQUEST['availability_id']) : 0);

$query = "SELECT p.*, u.full_name AS name FROM provider_profiles p JOIN users u ON p.user_id = u.id WHERE p.id = $provider_id";
$result = mysqli_query($conn, $query);
$provider = mysqli_fetch_assoc($result);

if (!$provider) {
    $provider = ['name' => 'د. سارة جونسون', 'specialization' => 'مقدمة خدمات طبية', 'consultation_price' => 150.00];
}

$customer_name = "رحمة عبد الناصر";
$customer_phone = "0912344567";
$customer_email = "ra@gmail.com";
$price = isset($provider['consultation_price']) ? $provider['consultation_price'] : 150.00;
?>

<div class="confirm-container" style="max-width: 900px; margin: 40px auto; padding: 0 20px; direction: rtl; font-family: inherit;">
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
        <h2 style="text-align: center; font-size: 22px; font-weight: 700; color: #0f172a; margin-bottom: 24px;">حجز موعدك</h2>

        <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 32px; gap: 16px;">
            <div style="display: flex; flex-direction: column; align-items: center; gap: 6px; font-size: 13px; color: #0B192C; font-weight: 600;">
                <div style="width: 32px; height: 32px; border-radius: 50%; background-color: #0B192C; color: #fff; display: flex; align-items: center; justify-content: center;"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg></div>
                <span>تأكيد الحجز</span>
            </div>
            <div style="width: 80px; height: 2px; background-color: #0B192C;"></div>
            <div style="display: flex; flex-direction: column; align-items: center; gap: 6px; font-size: 13px; color: #64748b;">
                <div style="width: 32px; height: 32px; border-radius: 50%; background-color: #0B192C; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: bold;">1</div>
                <span>تحديد التاريخ والوقت</span>
            </div>
        </div>

        <form action="payment.php" method="GET">
            <input type="hidden" name="provider_id" value="<?php echo $provider_id; ?>">
            <input type="hidden" name="availability_id" value="<?php echo $availability_id; ?>">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; background: #fff;">
                    <div style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 12px;">بياناتك</div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px;"><span style="color:#0f172a; font-weight:600;"><?php echo $customer_name; ?></span><span style="color:#64748b;">الإسم</span></div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px;"><span style="color:#0f172a; font-weight:600;" dir="ltr"><?php echo $customer_phone; ?></span><span style="color:#64748b;">رقم الهاتف</span></div>
                    <div style="display: flex; justify-content: space-between; font-size: 14px;"><span style="color:#0f172a; font-weight:600;"><?php echo $customer_email; ?></span><span style="color:#64748b;">البريد الإلكتروني</span></div>
                </div>

                <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; background: #fff;">
                    <div style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 12px;">تفاصيل الموعد</div>
                    <div style="display: flex; align-items: center; gap: 12px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9; margin-bottom: 12px;">
                        <div style="width: 40px; height: 40px; background-color: #cbd5e1; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #475569;">👤</div>
                        <div>
                            <h4 style="margin: 0; font-size: 14px; color: #0f172a;"><?php echo htmlspecialchars($provider['name']); ?></h4>
                            <span style="font-size: 11px; color: #64748b;"><?php echo htmlspecialchars($provider['specialization'] ?? 'مقدمة خدمات'); ?></span>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;"><span style="color:#0f172a; font-weight:500;">اليوم</span><span style="color:#64748b;">التاريخ:</span></div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;"><span style="color:#0f172a; font-weight:500;">05:30 مساءً</span><span style="color:#64748b;">الوقت:</span></div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;"><span style="color:#0f172a; font-weight:500;">google meet</span><span style="color:#64748b;">نوع الاستشارة:</span></div>
                    <div style="display: flex; justify-content: space-between; padding-top: 8px; border-top: 1px solid #f1f5f9; font-size: 16px; font-weight: 700;"><span style="color:#0B192C;">$<?php echo number_format($price, 0); ?></span><span style="color:#64748b;">إجمالي الرسوم:</span></div>
                </div>
            </div>

            <button type="submit" style="background-color: #0B192C; color: #ffffff; width: 100%; padding: 14px; border-radius: 10px; border: none; font-size: 15px; font-weight: 600; cursor: pointer;">تأكيد الحجز</button>
            <a href="book.php?provider_id=<?php echo $provider_id; ?>" style="background-color: #ffffff; color: #334155; width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 14px; font-weight: 500; text-align: center; display: block; text-decoration: none; margin-top: 10px;">الرجوع</a>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
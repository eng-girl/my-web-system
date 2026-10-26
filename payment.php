<?php
require_once 'config.php';
include 'includes/header.php';

$provider_id = isset($_REQUEST['provider_id']) ? intval($_REQUEST['provider_id']) : 1;
$availability_id = isset($_REQUEST['availability_id']) ? intval($_REQUEST['availability_id']) : 0;

$query = "SELECT p.*, u.full_name AS name FROM provider_profiles p JOIN users u ON p.user_id = u.id WHERE p.id = $provider_id";
$result = mysqli_query($conn, $query);
$provider = mysqli_fetch_assoc($result);

$price = isset($provider['consultation_price']) && $provider['consultation_price'] > 0 ? $provider['consultation_price'] : 250.00;
?>

<div style="max-width: 800px; margin: 40px auto; padding: 0 20px; direction: rtl; font-family: inherit;">
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 32px; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
        <h2 style="text-align: center; font-size: 22px; font-weight: 700; color: #0f172a; margin-bottom: 24px;">طريقة الدفع</h2>

        <form action="process_booking.php" method="POST" id="paymentForm">
            <input type="hidden" name="provider_id" value="<?php echo $provider_id; ?>">
            <input type="hidden" name="availability_id" value="<?php echo $availability_id; ?>">
            <input type="hidden" name="payment_method" value="prepaid_card">

            <div style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 12px;">طريقة الدفع المتاحة</div>

            <!-- بطاقة خيار كرت مسبق الدفع كخيار وحيد محدد تلقائياً -->
            <div style="border: 2px solid #0B192C; border-radius: 12px; padding: 18px; display: flex; align-items: center; justify-content: space-between; background: #f8fafc; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 14px;">
                    <div style="width: 42px; height: 42px; border-radius: 10px; background-color: #0B192C; color: #ffffff; display: flex; align-items: center; justify-content: center;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                    </div>
                    <div>
                        <h4 style="margin: 0 0 2px 0; font-size: 15px; color: #0f172a;">كرت مسبق الدفع</h4>
                        <p style="margin: 0; font-size: 12px; color: #64748b;">الدفع عن طريق الشحن ببطاقة مسبقة الدفع</p>
                    </div>
                </div>
                <div style="color: #0B192C;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
            </div>

            <!-- حقل إدخال رمز الكرت -->
            <div style="margin-bottom: 20px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 10px; padding: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 8px;">رمز الكرت مسبق الدفع <span style="color: #ef4444;">*</span></label>
                <input type="text" name="prepaid_code" id="prepaid_code_input" placeholder="أدخل رمز الكرت (مثال: CRD-XXXX-XXXX)" style="width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; background: #fff;" dir="ltr" required>
            </div>

            <!-- ملخص السعر -->
            <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; background-color: #f8fafc; margin-bottom: 24px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; color: #475569;">
                    <span>رسوم الاستشارة</span>
                    <span>$<?php echo number_format($price, 2); ?></span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-top: 12px; border-top: 1px solid #e2e8f0; font-size: 16px; font-weight: 700; color: #0f172a;">
                    <span>الإجمالي المستحق</span>
                    <span style="color: #0B192C;">$<?php echo number_format($price, 2); ?></span>
                </div>
            </div>

            <button type="submit" style="background-color: #0B192C; color: #ffffff; width: 100%; padding: 14px; border-radius: 10px; border: none; font-size: 15px; font-weight: 600; cursor: pointer;">إتمام الحجز والدفع</button>
            <a href="confirm_booking.php?provider_id=<?php echo $provider_id; ?>&selected_availability_id=<?php echo $availability_id; ?>" style="background-color: #ffffff; color: #334155; width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #cbd5e1; font-size: 14px; font-weight: 500; text-align: center; display: block; text-decoration: none; margin-top: 10px;">الرجوع</a>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
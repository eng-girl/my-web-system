<?php
require_once 'config.php';
include 'includes/header.php';

$provider_id = isset($_GET['provider_id']) ? intval($_GET['provider_id']) : 1;

$query = "SELECT p.*, u.full_name AS name FROM provider_profiles p JOIN users u ON p.user_id = u.id WHERE p.id = $provider_id";
$result = mysqli_query($conn, $query);
$provider = mysqli_fetch_assoc($result);

if (!$provider) {
    $provider = ['name' => 'د. سارة جونسون', 'specialization' => 'استشاري تقنية المعلومات'];
}

$today = date('Y-m-d');
$tomorrow = date('Y-m-d', strtotime('+1 day'));
$grouped_slots = [
    $today => [
        ['id' => 101, 'start_time' => $today . ' 14:30:00'],
        ['id' => 102, 'start_time' => $today . ' 16:00:00'],
        ['id' => 103, 'start_time' => $today . ' 17:30:00'],
    ],
    $tomorrow => [
        ['id' => 104, 'start_time' => $tomorrow . ' 14:30:00'],
        ['id' => 105, 'start_time' => $tomorrow . ' 16:00:00'],
    ]
];
?>

<style>
    .booking-container {
        max-width: 900px;
        margin: 40px auto;
        padding: 0 20px;
        direction: rtl;
        font-family: inherit;
    }

    .booking-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    }

    .booking-title {
        text-align: center;
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 24px;
    }

    .stepper-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 32px;
        gap: 16px;
    }

    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #64748b;
    }

    .step-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #e2e8f0;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .step-item.active .step-circle {
        background-color: #0B192C;
        color: #ffffff;
    }

    .step-item.active {
        color: #0B192C;
        font-weight: 600;
    }

    .step-line {
        width: 80px;
        height: 2px;
        background-color: #e2e8f0;
    }

    .section-label {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
        text-align: right;
    }

    .provider-summary-box {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        background-color: #fafafa;
    }

    .provider-info-mini {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .avatar-small {
        width: 44px;
        height: 44px;
        background-color: #cbd5e1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
    }

    .slots-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .slot-box {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        background: #ffffff;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }

    .slot-box.selected-date {
        border-color: #0B192C;
        box-shadow: 0 0 0 1px #0B192C;
        background-color: #f8fafc;
    }

    .slot-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        font-size: 13px;
        color: #64748b;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 8px;
    }

    .slot-times {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .time-pill {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 6px 14px;
        font-size: 13px;
        color: #334155;
        background: #fff;
        cursor: pointer;
        transition: all 0.2s;
    }

    .time-pill.selected-time {
        background-color: #0B192C;
        color: #ffffff;
        border-color: #0B192C;
    }

    .btn-continue {
        background-color: #0B192C;
        color: #ffffff;
        width: 100%;
        padding: 14px;
        border-radius: 10px;
        border: none;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 16px;
    }

    .btn-back {
        background-color: #ffffff;
        color: #334155;
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        margin-top: 10px;
        text-align: center;
        display: block;
        text-decoration: none;
    }

    @media(max-width: 768px) {
        .slots-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="booking-container">
    <div class="booking-card">
        <h2 class="booking-title">حجز موعدك</h2>

        <div class="stepper-wrapper">
            <div class="step-item">
                <div class="step-circle">2</div>
                <span>تأكيد الحجز</span>
            </div>
            <div class="step-line"></div>
            <div class="step-item active">
                <div class="step-circle">1</div>
                <span>تحديد التاريخ والوقت</span>
            </div>
        </div>

        <form action="confirm_booking.php" method="GET" id="bookingForm">
            <input type="hidden" name="provider_id" value="<?php echo $provider_id; ?>">
            <input type="hidden" name="selected_availability_id" id="selected_availability_id" value="">

            <div class="section-label">معلومات مقدم الخدمة</div>
            <div class="provider-summary-box">
                <div class="provider-info-mini">
                    <div class="avatar-small">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                    </div>
                    <div>
                        <h4 style="margin: 0; font-size: 15px; color: #0f172a;"><?php echo htmlspecialchars($provider['name']); ?></h4>
                        <span style="font-size: 12px; color: #64748b;"><?php echo htmlspecialchars($provider['specialization'] ?? 'استشاري تقنية المعلومات'); ?></span>
                    </div>
                </div>
            </div>

            <div class="section-label">المواعيد القادمة (اختر التاريخ)</div>
            <div class="slots-grid">
                <?php $isFirstDate = true;
                foreach ($grouped_slots as $date => $slots):
                    $dayLabel = ($date == date('Y-m-d')) ? 'اليوم' : (($date == date('Y-m-d', strtotime('+1 day'))) ? 'غداً' : $date);
                ?>
                    <div class="slot-box <?php echo $isFirstDate ? 'selected-date' : ''; ?>" onclick="selectDateCard(this)">
                        <div class="slot-header">
                            <span><?php echo $dayLabel; ?></span>
                            <span><?php echo $date; ?></span>
                            <?php if ($isFirstDate): ?>
                                <svg class="check-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0B192C" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            <?php endif; ?>
                        </div>
                        <div style="font-size: 12px; color: #64748b; margin-bottom: 6px;">المواعيد المتاحة</div>
                        <div class="slot-times">
                            <?php foreach ($slots as $slot):
                                $timeFormatted = date('h:i A', strtotime($slot['start_time']));
                                $timeFormatted = str_replace(['AM', 'PM'], ['صباحاً', 'مساءً'], $timeFormatted);
                            ?>
                                <span class="time-pill" data-id="<?php echo $slot['id']; ?>" onclick="selectTimePill(event, this)">
                                    <?php echo $timeFormatted; ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php $isFirstDate = false;
                endforeach; ?>
            </div>

            <button type="submit" class="btn-continue">المتابعة</button>
            <a href="view_provider.php?id=<?php echo $provider_id; ?>" class="btn-back">الرجوع</a>
        </form>
    </div>
</div>

<script>
    function selectDateCard(cardElement) {
        document.querySelectorAll('.slot-box').forEach(box => {
            box.classList.remove('selected-date');
            let icon = box.querySelector('.check-icon');
            if (icon) icon.remove();
        });
        cardElement.classList.add('selected-date');

        let header = cardElement.querySelector('.slot-header');
        if (!header.querySelector('.check-icon')) {
            let checkSvg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
            checkSvg.setAttribute('class', 'check-icon');
            checkSvg.setAttribute('width', '18');
            checkSvg.setAttribute('height', '18');
            checkSvg.setAttribute('viewBox', '0 0 24 24');
            checkSvg.setAttribute('fill', 'none');
            checkSvg.setAttribute('stroke', '#0B192C');
            checkSvg.setAttribute('stroke-width', '2');
            checkSvg.innerHTML = '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>';
            header.appendChild(checkSvg);
        }
    }

    function selectTimePill(event, pillElement) {
        event.stopPropagation();
        document.querySelectorAll('.time-pill').forEach(pill => {
            pill.classList.remove('selected-time');
        });
        pillElement.classList.add('selected-time');

        let availabilityId = pillElement.getAttribute('data-id');
        document.getElementById('selected_availability_id').value = availabilityId;

        let parentCard = pillElement.closest('.slot-box');
        selectDateCard(parentCard);
    }

    document.addEventListener("DOMContentLoaded", function() {
        let firstPill = document.querySelector('.time-pill');
        if (firstPill) {
            firstPill.click();
        }
    });

    document.getElementById('bookingForm').addEventListener('submit', function(e) {
        let selectedId = document.getElementById('selected_availability_id').value;
        if (!selectedId) {
            e.preventDefault();
            alert('الرجاء اختيار وقت الموعد للمتابعة.');
        }
    });
</script>

<?php include 'includes/footer.php'; ?>
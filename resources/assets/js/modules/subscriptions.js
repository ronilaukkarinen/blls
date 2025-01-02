console.log('subscriptions.js imported');

document.addEventListener('DOMContentLoaded', () => {

  // Hide validation errors by default
  document.querySelectorAll('.validation-error').forEach(el => el.style.display = 'none');

  // Add click handlers for new subscription button
  document.querySelectorAll('.add-new-subscription').forEach(btn => {
    btn.addEventListener('click', () => {
      document.body.classList.add('modal-opened');
      const modal = document.querySelector('.modal-subscription-new');
      if (modal) {
        document.body.appendChild(modal);
        modal.style.display = 'flex';
        modal.classList.add('show');
      }
    });
  });

  // Event delegation for all click events
  document.addEventListener('click', e => {
    // Handle subscription item clicks
    if (e.target.closest('.items-subscriptions .item')) {
      const item = e.target.closest('.item');
      const rowId = item.dataset.id;
      document.body.classList.add('modal-opened');
      const modal = document.querySelector(`.modal-subscription-${rowId}`);
      if (modal) {
        document.body.appendChild(modal);
        modal.style.display = 'none';
        setTimeout(() => {
          modal.style.display = 'flex';
          modal.classList.add('show');
        }, 10);
      }
    }

    // Check subscription dates and update if needed
    if (e.target.matches('.subscription-due')) {
      const originalDate = e.target.dataset.originalDate;
      const thisId = e.target.dataset.id;
      const now = Date.now();
      const d = moment(originalDate, "YYYY-MM-DD H:i:s");

      if (d < now) {
        fetch('updatesubscriptiondate', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({
            update: 1,
            id: thisId,
            subscription_date: originalDate
          })
        });
      }
    }

    // Update subscription
    if (e.target.matches('#update-subscription')) {
      const editId = e.target.dataset.id;
      const modal = document.querySelector(`.modal-subscription-${editId}`);
      if (!modal) return;

      const billerEl = modal.querySelector('#subscription_biller');
      const amountEl = modal.querySelector('#subscription_amount');
      const monthDayEl = modal.querySelector('#subscription_month_day');
      const planEl = modal.querySelector('#subscription_plan');

      const data = {
        update: 1,
        id: editId,
        subscription_biller: billerEl && billerEl.value || '',
        subscription_amount: amountEl && amountEl.value || '',
        subscription_month_day: monthDayEl && monthDayEl.value || '',
        subscription_plan: planEl && planEl.value || ''
      };

      handleSubscriptionRequest('editsubscription', data);
    }

    // Remove subscription
    if (e.target.matches('#remove-subscription')) {
      const editId = e.target.dataset.id;
      handleModalClose();
      fadeOutElement(`.item-${editId}`);
      handleSubscriptionRequest('removesubscription', { id: editId });
    }

    // Handle subscription status
    if (e.target.matches('#make-inactive, #make-active')) {
      const action = e.target.id;
      const editId = e.target.dataset.id;
      const modal = document.querySelector(`.modal-subscription-${editId}`);
      if (!modal) return;

      const billerEl = modal.querySelector('#subscription_biller');
      const amountEl = modal.querySelector('#subscription_amount');
      const monthDayEl = modal.querySelector('#subscription_month_day');
      const planEl = modal.querySelector('#subscription_plan');

      const data = {
        update: 1,
        id: editId,
        subscription_active: action === 'make-active' ? 1 : 0,
        subscription_biller: billerEl && billerEl.value || '',
        subscription_amount: amountEl && amountEl.value || '',
        subscription_month_day: monthDayEl && monthDayEl.value || '',
        subscription_plan: planEl && planEl.value || ''
      };

      handleSubscriptionRequest('handlesubscription', data);
    }

    // Save new subscription
    if (e.target.matches('#submit-subscription')) {
      const modal = document.querySelector('.modal-subscription-new');
      if (!modal) return;

      const billerEl = modal.querySelector('#subscription_biller');
      const amountEl = modal.querySelector('#subscription_amount');
      const monthDayEl = modal.querySelector('#subscription_month_day');
      const planEl = modal.querySelector('#subscription_plan');

      const data = {
        save: 1,
        subscription_biller: billerEl && billerEl.value || '',
        subscription_amount: amountEl && amountEl.value || '',
        subscription_month_day: monthDayEl && monthDayEl.value || '',
        subscription_plan: planEl && planEl.value || ''
      };

      handleSubscriptionRequest('addsubscription', data);
    }
  });
});

// Helper functions
function handleModalClose() {
  document.body.classList.remove('modal-opened');
  document.querySelectorAll('.modal').forEach(modal => modal.classList.remove('show'));
}

function fadeOutElement(selector) {
  const element = document.querySelector(selector);
  if (element) {
    element.style.transition = 'opacity 0.3s';
    element.style.opacity = '0';
    setTimeout(() => element.style.display = 'none', 300);
  }
}

function handleSubscriptionRequest(url, data) {
  fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify(data)
  })
  .then(response => response.json())
  .then(response => {
    if (response.errors) {
      showValidationError(response.errors);
    } else {
      handleModalClose();
      location.reload();
    }
  });
}

function showValidationError(errors) {
  const validationError = document.querySelector('.validation-error');
  if (validationError) {
    validationError.style.display = 'block';
    const errorFields = validationError.querySelector('.erroneous-fields');
    if (errorFields) {
      errorFields.textContent = errors.slice(0, -1).join(', ');
    }
    setTimeout(() => {
      validationError.style.display = 'none';
    }, 3000);
    console.log(errors);
  }
}

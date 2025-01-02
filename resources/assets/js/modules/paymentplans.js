console.log('paymentplans.js imported');

document.addEventListener('DOMContentLoaded', () => {
  // Hide validation errors by default
  document.querySelectorAll('.validation-error').forEach(el => el.style.display = 'none');

  // Add click handlers for new payment plan button
  document.querySelectorAll('.add-new-paymentplan').forEach(btn => {
    btn.addEventListener('click', () => {
      document.body.classList.add('modal-opened');
      const modal = document.querySelector('.modal-paymentplan-new');
      document.body.appendChild(modal);
      modal.style.display = 'flex';
      modal.classList.add('show');
    });
  });

  // Open modal when clicking single items
  const itemsContainer = document.querySelector('.items-paymentplans');
  if (itemsContainer) {
    itemsContainer.querySelectorAll('.item').forEach(item => {
      item.addEventListener('click', () => {
        const rowId = item.dataset.id;
        document.body.classList.add('modal-opened');
        const modal = document.querySelector(`.modal-paymentplan-${rowId}`);
        document.body.appendChild(modal);
        modal.style.display = 'flex';
        modal.classList.add('show');
      });
    });
  }

  // Save payment plan to database
  document.addEventListener('click', function(e) {
    if (e.target.matches('#submit-paymentplan')) {
      const modal = document.querySelector('.modal-paymentplan-new');
      const data = {
        save: 1,
        paymentplan_name: modal.querySelector('#paymentplan-name').value,
        paymentplan_months_paid: modal.querySelector('#paymentplan-months-paid').value,
        paymentplan_months_total: modal.querySelector('#paymentplan-months-total').value
      };

      fetch('addpaymentplan', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      })
      .then(response => {
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
          return response.json();
        }
        return response.text();
      })
      .then(response => {
        if (typeof response === 'string') {
          // Handle HTML response
          document.body.classList.remove('modal-opened');
          document.querySelectorAll('.modal').forEach(modal => modal.classList.remove('show'));
          location.reload();
        } else {
          // Handle JSON response
          if (response.errors) {
            const validationError = document.querySelector('.validation-error');
            validationError.style.display = 'block';
            validationError.querySelector('.erroneous-fields').textContent = response.errors.join(', ');

            setTimeout(() => {
              validationError.style.display = 'none';
            }, 3000);
          } else {
            document.body.classList.remove('modal-opened');
            document.querySelectorAll('.modal').forEach(modal => modal.classList.remove('show'));
            location.reload();
          }
        }
      })
      .catch(error => {
        console.error('Error:', error);
        const validationError = document.querySelector('.validation-error');
        validationError.style.display = 'block';
        validationError.querySelector('.erroneous-fields').textContent = 'An error occurred while saving';

        setTimeout(() => {
          validationError.style.display = 'none';
        }, 3000);
      });
    }
  });

  // Edit Payment plan
  document.addEventListener('click', function(e) {
    if (e.target.matches('#update-paymentplan')) {
      const editId = e.target.dataset.id;
      const modal = document.querySelector(`.modal-paymentplan-${editId}`);
      const paymentplanName = modal.querySelector('#paymentplan-name').value;
      const paymentplanMonthsPaid = modal.querySelector('#paymentplan-months-paid').value;
      const paymentplanMonthsTotal = modal.querySelector('#paymentplan-months-total').value;

      // Close modals
      document.body.classList.remove('modal-opened');
      document.querySelectorAll('.modal').forEach(modal => modal.classList.remove('show'));

      fetch('editpaymentplan', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
          update: 1,
          id: editId,
          paymentplan_name: paymentplanName,
          paymentplan_months_paid: paymentplanMonthsPaid,
          paymentplan_months_total: paymentplanMonthsTotal
        })
      })
      .then(response => response.text())
      .then(html => {
        document.querySelector(`.item-${editId}`).outerHTML = html;
      });
    }
  });

  // Remove paymentplan
  document.addEventListener('click', function(e) {
    if (e.target.matches('#remove-paymentplan')) {
      const editId = e.target.dataset.id;

      // Close modals
      document.body.classList.remove('modal-opened');
      document.querySelectorAll('.modal').forEach(modal => modal.classList.remove('show'));

      // Fade out
      fadeOut(document.querySelector(`.item-${editId}`));

      fetch('removepaymentplan', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
          id: editId
        })
      });
    }
  });

  // Mark as paid/unpaid actions
  ['paid-button', 'unpaid-button'].forEach(buttonId => {
    document.addEventListener('click', function(e) {
      if (e.target.matches(`#${buttonId}`)) {
        const id = e.target.dataset.id;

        // Close modals
        document.body.classList.remove('modal-opened');
        document.querySelectorAll('.modal-bill').forEach(modal => modal.classList.remove('show'));

        // Fade out row
        fadeOut(document.querySelector(`.row-id-${id}`));

        fetch(buttonId === 'paid-button' ? 'markppaid' : 'markpunpaid', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({ id })
        });
      }
    });
  });

  // Helper functions for fade effects
  function fadeIn(element) {
    element.style.opacity = 0;
    element.style.display = 'block';

    let opacity = 0;
    const timer = setInterval(() => {
      opacity += 0.1;
      if (opacity >= 1) {
        clearInterval(timer);
        element.style.opacity = 1;
      }
      element.style.opacity = opacity;
    }, 50);
  }

  function fadeOut(element) {
    let opacity = 1;
    const timer = setInterval(() => {
      opacity -= 0.1;
      if (opacity <= 0) {
        clearInterval(timer);
        element.style.display = 'none';
      }
      element.style.opacity = opacity;
    }, 50);
  }
});

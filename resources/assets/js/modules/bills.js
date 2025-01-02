document.addEventListener('DOMContentLoaded', () => {
  // Hide validation errors by default
  document.querySelectorAll('.validation-error').forEach(el => el.style.display = 'none');

  // Save bill to database
  document.addEventListener('click', e => {
    if (e.target.matches('#submit-button')) {
      const data = {
        save: 1,
        biller: document.getElementById('biller').value,
        billnumber: document.getElementById('billnumber').value,
        virtualcode: document.getElementById('virtualcode').value,
        refnumber: document.getElementById('refnumber').value,
        accountnumber: document.getElementById('accountnumber').value,
        type: document.getElementById('type').value,
        description: document.getElementById('description').value,
        amount: document.getElementById('amount').value,
        duedate: document.getElementById('duedate').value
      };

      fetch('addbill', {
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
          const validationError = document.querySelector('.validation-error');
          validationError.style.display = 'block';
          validationError.querySelector('.erroneous-fields').textContent = response.errors.slice(0, -1).join(', ');

          setTimeout(() => {
            validationError.style.display = 'none';
          }, 3000);

          console.log(response);
        } else {
          // Clear form
          ['biller', 'billnumber', 'virtualcode', 'refnumber', 'accountnumber',
           'type', 'description', 'amount', 'duedate'].forEach(id => {
            document.getElementById(id).value = '';
          });

          // Close modals
          document.body.classList.remove('modal-opened');
          document.querySelectorAll('.modal-bill').forEach(modal => modal.classList.remove('show'));

          // Reload page
          location.reload();
        }
      });
    }
  });

  // Remove bill
  document.addEventListener('click', e => {
    if (e.target.matches('#remove-bill')) {
      const removeId = e.target.dataset.id;

      // Close modals
      document.body.classList.remove('modal-opened');
      document.querySelectorAll('.modal').forEach(modal => modal.classList.remove('show'));

      // Fade out row
      const row = document.querySelector(`.row-id-${removeId}`);
      row.style.transition = 'opacity 0.3s';
      row.style.opacity = '0';
      setTimeout(() => row.style.display = 'none', 300);

      fetch('removebill', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ id: removeId })
      });
    }
  });

  // Edit bill
  document.addEventListener('click', e => {
    if (e.target.matches('.edit')) {
      const editId = e.target.dataset.id;
      const editBill = document.querySelector(`.row-id-${editId}`);

      // Close modals
      document.body.classList.remove('modal-opened');
      document.querySelectorAll('.modal-bill').forEach(modal => modal.classList.remove('show'));

      // Open add/edit modal
      document.body.classList.add('modal-opened');
      const modal = document.querySelector('.modal-bill-new');
      document.body.appendChild(modal);
      modal.style.display = 'block';
      modal.classList.add('show');
      document.querySelector('.bill-title').textContent = 'Muokkaa laskua';

      // Grab the bill to be edited
      const billData = {
        biller: editBill.querySelector('.biller_text').textContent,
        billnumber: editBill.querySelector('.billnumber_text').textContent,
        virtualcode: editBill.querySelector('.virtualcode_text').textContent,
        refnumber: editBill.querySelector('.refnumber_text').textContent,
        accountnumber: editBill.querySelector('.accountnumber_text').textContent,
        type: editBill.querySelector('.type_text').textContent,
        description: editBill.querySelector('.description_text').textContent,
        amount: editBill.querySelector('.formatted-amount').textContent,
        duedate: editBill.querySelector('.formatted-duedate').dataset.copyToClipboard
      };

      // Place bill details into the form
      Object.entries(billData).forEach(([key, value]) => {
        document.getElementById(key).value = value;
      });

      document.getElementById('submit-button').style.display = 'none';
      document.getElementById('update-button').style.display = 'block';
    }
  });

  // Update bill
  document.addEventListener('click', e => {
    if (e.target.matches('#update-button')) {
      const data = {
        update: 1,
        id: editId,
        biller: document.getElementById('biller').value,
        billnumber: document.getElementById('billnumber').value,
        virtualcode: document.getElementById('virtualcode').value,
        refnumber: document.getElementById('refnumber').value,
        accountnumber: document.getElementById('accountnumber').value,
        type: document.getElementById('type').value,
        description: document.getElementById('description').value,
        amount: document.getElementById('amount').value,
        duedate: document.getElementById('duedate').value
      };

      fetch('editbill', {
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
          const validationError = document.querySelector('.validation-error');
          validationError.style.display = 'block';
          validationError.querySelector('.erroneous-fields').textContent = response.errors.slice(0, -1).join(', ');

          setTimeout(() => {
            validationError.style.display = 'none';
          }, 3000);

          console.log(response);
        } else {
          // Clear form
          ['biller', 'billnumber', 'virtualcode', 'refnumber', 'accountnumber',
           'type', 'description', 'amount', 'duedate'].forEach(id => {
            document.getElementById(id).value = '';
          });

          document.getElementById('submit-button').style.display = 'block';
          document.getElementById('update-button').style.display = 'none';

          // Close modals
          document.body.classList.remove('modal-opened');
          document.querySelectorAll('.modal-bill').forEach(modal => modal.classList.remove('show'));

          // Reload page
          location.reload();
        }
      });
    }
  });

  // Mark as paid/unpaid actions
  ['paid', 'unpaid'].forEach(status => {
    document.addEventListener('click', e => {
      if (e.target.matches(`.mark-as-${status}`)) {
        const id = e.target.dataset.id;

        // Close modals
        document.body.classList.remove('modal-opened');
        document.querySelectorAll('.modal-bill').forEach(modal => modal.classList.remove('show'));

        // Update total if marking as paid
        if (status === 'paid') {
          const amountToSubtract = document.querySelector(`.modal-bill-${id} .formatted-amount`).dataset.originalAmount;
          const currentTotal = document.querySelector('.amount-updatable').dataset.amount;
          const sum = Number(currentTotal) - Number(amountToSubtract);
          document.querySelector('.amount-updatable').textContent = sum;
        }

        // Fade out row
        const row = document.querySelector(`.row-id-${id}`);
        row.style.transition = 'opacity 0.3s';
        row.style.opacity = '0';
        setTimeout(() => row.style.display = 'none', 300);

        fetch(`markas${status}`, {
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
});

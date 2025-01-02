console.log('creditcards.js imported');

document.addEventListener('DOMContentLoaded', () => {
  // Hide validation errors by default
  document.querySelectorAll('.validation-error').forEach(el => el.style.display = 'none');

  // Add click handlers for new credit card button
  document.querySelectorAll('.add-new-credit-card').forEach(btn => {
    btn.addEventListener('click', () => {
      document.body.classList.add('modal-opened');
      const modal = document.querySelector('.modal-credit-card-new');
      document.body.appendChild(modal);
      modal.style.display = 'flex';
      modal.classList.add('show');
    });
  });

  // Open modal when clicking single items
  const itemsContainer = document.querySelector('.items-creditcards');
  if (itemsContainer) {
    itemsContainer.querySelectorAll('.item').forEach(item => {
      item.addEventListener('click', () => {
        const rowId = item.dataset.id;
        document.body.classList.add('modal-opened');
        const modal = document.querySelector(`.modal-credit-card-${rowId}`);
        document.body.appendChild(modal);
        modal.style.display = 'flex';
        modal.classList.add('show');
      });
    });
  }

  // Save credit card to database
  document.addEventListener('click', (e) => {
    if (e.target.matches('#submit-credit-card')) {
      // Close modals
      document.body.classList.remove('modal-opened');
      document.querySelectorAll('.modal').forEach(modal => modal.classList.remove('show'));

      const modal = document.querySelector('.modal-credit-card-new');
      const data = {
        save: 1,
        creditor: modal.querySelector('#creditor').value,
        expirationdate: modal.querySelector('#expirationdate').value,
        lastfourdigits: modal.querySelector('#lastfourdigits').value,
        monthlyamount: modal.querySelector('#monthlycut').value,
        creditcard_amount_paid: modal.querySelector('#creditcard_amount_paid').value,
        creditcard_amount_total: modal.querySelector('#creditcard_amount_total').value
      };

      fetch('addcreditcard', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      })
      .then(response => response.text())
      .then(html => {
        const lastItem = document.querySelector('.items-credit-cards > .item:last-child');
        lastItem.insertAdjacentHTML('afterend', html);
        location.reload();
      });
    }
  });

  // Edit credit card
  document.addEventListener('click', (e) => {
    if (e.target.matches('#update-credit-card')) {
      const editId = e.target.dataset.id;
      const modal = document.querySelector(`.modal-credit-card-${editId}`);

      const data = {
        update: 1,
        id: editId,
        creditor: modal.querySelector('#creditor').value,
        expirationdate: modal.querySelector('#expirationdate').value,
        lastfourdigits: modal.querySelector('#lastfourdigits').value,
        monthlyamount: modal.querySelector('#monthlycut').value,
        creditcard_amount_paid: modal.querySelector('#creditcard_amount_paid').value,
        creditcard_amount_total: modal.querySelector('#creditcard_amount_total').value
      };

      // Close modals
      document.body.classList.remove('modal-opened');
      document.querySelectorAll('.modal').forEach(modal => modal.classList.remove('show'));

      fetch('editcreditcard', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
      })
      .then(response => response.text())
      .then(html => {
        document.querySelector(`.item-${editId}`).outerHTML = html;
      });
    }
  });

  // Remove credit card
  document.addEventListener('click', (e) => {
    if (e.target.matches('#remove-credit-card')) {
      const editId = e.target.dataset.id;

      // Close modals
      document.body.classList.remove('modal-opened');
      document.querySelectorAll('.modal').forEach(modal => modal.classList.remove('show'));

      // Fade out
      const item = document.querySelector(`.item-${editId}`);
      item.style.transition = 'opacity 0.3s';
      item.style.opacity = '0';
      setTimeout(() => item.style.display = 'none', 300);

      fetch('removecreditcard', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ id: editId })
      });
    }
  });
});

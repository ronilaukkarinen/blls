document.addEventListener('DOMContentLoaded', () => {
  // Apple-like fade on load
  setTimeout(() => {
    document.querySelectorAll('.opacity-on-load').forEach(el => {
      el.classList.add('fade-in');
    });
  }, 500);

  // Inbox Zero handling
  document.querySelectorAll('.items-paymentplans, .items-creditcards, .items-subscriptions').forEach(container => {
    if (!container.innerHTML.trim()) {
      container.insertAdjacentHTML('beforeend', `
        <div class="inbox-zero">
          <div class="freedom freedom-fireworks">
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 128 128" xml:space="preserve"><style>.icon-fireworks{display:none;fill:#141414}</style><g id="row3"><path id="icon-fireworks:5_2_" class="icon-fireworks" d="M109.3 46.5c-1.7-6.3-5.2-11.7-10.1-15.5-.6-4.8-3.3-9-7.1-11.5 1.5-2.7 4-5.6 7.9-7.3L98.6 9c-4.8 2.1-7.7 5.6-9.5 8.8-1.9-.8-4-1.2-6.2-1.2-6.7 0-12.5 4-15 9.8-5.6-4.8-12.5-7.4-19.8-7.4-15.7 0-28.7 11.9-30.5 27.5C7.7 47.5 0 55.7 0 65.8c0 10.7 8.7 19.4 19.4 19.4.5 0 1 0 1.6-.1L32 119h63.9l11.2-33.9c.5 0 1 .1 1.5.1 10.7 0 19.4-8.7 19.4-19.4 0-10.4-8.3-19-18.7-19.3zM87 19.6c.4 0 .8 0 1.2.1-1.3 2.9-1.7 5.2-1.8 5.4l3.3.5c0-.1.3-1.9 1.4-4.3 1.1 1.1 1.7 2.5 1.7 4.1 0 3.2-2.6 5.8-5.8 5.8-3.2 0-5.8-2.6-5.8-5.8 0-3.2 2.6-5.8 5.8-5.8zm-44.3 92.2h-5.3l-9.7-27.2H33l9.7 27.2zm9.8 0L50 84.6h5.1l2.4 27.2h-5zm22.4 0h-5.1l2.4-27.2h5.1l-2.4 27.2zm15.1 0H84.6l9.7-27.2h5.4L90 111.8zm18.8-31.7h-.2c-4.3 0-8.3-1.9-11.1-5.2l-1.4-1.8-1.9 1.3c-4 2.6-8.6 4-13.5 4-5.9 0-11.5-2.1-15.9-5.9l-1.4-1.2-1.6 1c-4.1 2.7-8.9 4.1-13.7 4.1-4.7 0-9.2-1.3-13.2-3.7l-2.1-1.3-1.3 2.1c-2.6 4.2-7.1 6.7-12.1 6.7h-.1c-7.9 0-14.2-6.4-14.2-14.3 0-8 6.7-14.5 14.8-14.3l2.5.1.1-2.5c.6-14 11.8-25.1 25.6-25.1 6.9 0 13.4 2.8 18.3 7.8l.2.2v.9c0 9.1 7.3 16.4 16.4 16.4 7.5 0 13.9-5.1 15.8-12 3.1 3.3 5.2 7.5 6.1 12.1l.4 2.3 2.3-.2c.4 0 .8-.1 1.2-.1 7.9 0 14.3 6.4 14.3 14.3-.2 7.9-6.5 14.2-14.3 14.3z"></path><path id="icon-fireworks:4_2_" class="icon-fireworks" d="M128 44.6C124.9 43 89.5 19.7 66.3 4.4l-1.7-1.1L.4 44.4l.4.6-.8-.4v80.2h128V44.6zm-27.7 18.1L69.1 83.1C74 78.4 80.8 70.4 78.9 64c-2.1-7.2-10.4-5.2-14.5-2.5-4.1-2.8-12-5.1-14.5 2.5-2.1 6.3 4.7 14.3 9.6 19.1L27.7 62.5V46.7h72.6v16zm4.2-2.7V42.5h-81v17.3L5.8 48.3l58.8-37.6c36.5 24.2 51.2 33.9 57.6 37.7L104.5 60z"></path><path id="icon-fireworks:3_2_" class="icon-fireworks" d="M61.7 3.4l-7-3.4 3.7 6.9c.1.1 5.7 10.9 2.5 23-1 4-6.1 6.6-10.5 8.9-2.6 1.4-5 2.7-6.7 4.2-13.7 11.6-7 20.5-7 20.5v15.2c0 2.6 2.1 4.7 4.7 4.7H43l4.2 44.6h33.6L85 83.4h2c2.6 0 4.7-2.1 4.7-4.7V63.5l.4-2.1c6.7-39.4-30-57.8-30.4-58zM47.1 46.7c1.3-1.1 3.4-2.2 5.7-3.4 5.1-2.7 11.4-6 13-12.1 2-7.6 1-14.6-.3-19.5 9.1 6.5 25.1 21.6 22.2 46.8H40.4c0-2.4 1-6.7 6.7-11.8z"></path><path id="icon-fireworks:2_2_" class="icon-fireworks" d="M34.5 25.5c-4.9 0-8.9 4-8.9 8.9s4 8.9 8.9 8.9 8.9-4 8.9-8.9-4-8.9-8.9-8.9zM128 38.2c0 1.2-.7 2.3-1.7 2.9L106 52.9v46.8c0 1.5-1.2 2.8-2.8 2.8h-2.7c-1.5 0-2.8-1.2-2.8-2.8V79.4c0-1.4-1.2-2.6-2.6-2.6-1.4 0-2.6 1.2-2.6 2.6v20.3c0 1.5-1.2 2.8-2.8 2.8h-2.6c-1.5 0-2.8-1.2-2.8-2.8V53.1l-21-10.6-18 10.4v46.8c0 1.5-1.2 2.8-2.8 2.8h-2.7c-1.5 0-2.8-1.2-2.8-2.8V79.4c0-1.4-1.2-2.6-2.6-2.6-1.4 0-2.6 1.2-2.6 2.6v20.3c0 1.5-1.2 2.8-2.8 2.8h-2.7c-1.5 0-2.8-1.2-2.8-2.8V53.1L2.1 42.2c-1.3-.6-2.1-2-2.1-3.4 0-2.7 2.8-4.6 5.3-3.5l29.2 12.3L62.6 35c.4-.2.9-.3 1.3-.3.5 0 1.1.1 1.6.4.2 0 .4.1.5.2l29.2 12.3L123.3 35c.4-.2.9-.3 1.3-.3 1.8.1 3.4 1.5 3.4 3.5zM95.2 25.5c-4.9 0-8.9 4-8.9 8.9s4 8.9 8.9 8.9 8.9-4 8.9-8.9-4-8.9-8.9-8.9z"></path><path id="icon-fireworks:1_2_" class="icon-fireworks" d="M102.4 0v15.2c0 3.1-2.6 5.7-5.7 5.7S91 18.3 91 15.2V0H36.8v15.2c0 3.1-2.6 5.7-5.7 5.7s-5.7-2.6-5.7-5.7V0H4v128h120V0h-21.6zm14 120.4H11.6V30.7h104.9v89.7zM63.6 64H45.7V46.1h17.9V64zm22.7-17.9H68.4V64h17.9V46.1zm22.8 0H91.2V64h17.9V46.1zM63.6 86.7H45.7V68.8h17.9v17.9zm-22.8 0H22.9V68.8h17.9v17.9zm45.5-17.9H68.4v17.9h17.9V68.8zm22.8 0H91.2v17.9h17.9V68.8zm-68.3 40.7H22.9V91.6h17.9v17.9zm22.8-17.9H45.7v17.9h17.9V91.6zm22.7 0H68.4v17.9h17.9V91.6z"></path></g><g id="row2"><path id="icon-fireworks:5_4_" class="icon-fireworks" d="M0 107.2c0 3.4 2.7 6.2 6.1 6.2H122c3.3 0 6.1-2.7 6.1-6.1v-.1H0zm121.9-85.4H6.1c-3.3 0-6.1 2.7-6.1 6.1v75.3h128V27.9c0-3.4-2.7-6.1-6.1-6.1zM20.4 42.2c-3.3 0-5.9-2.6-5.9-5.9 0-3.3 2.6-5.9 5.9-5.9 3.3 0 5.9 2.6 5.9 5.9 0 3.3-2.6 5.9-5.9 5.9zM64 98.8c-17.3 0-31.3-14-31.3-31.3s14-31.3 31.3-31.3 31.2 14 31.2 31.3c.1 17.3-13.9 31.3-31.2 31.3zm52.4-58.7c0 2.2-1.8 4-4 4H97.8c-2.2 0-4-1.8-4-4V35c0-2.2 1.8-4 4-4h14.5c2.2 0 4 1.8 4 4v5.1zm4.5-21.1v.7H93.8V19c0-2.4 2-4.4 4.4-4.4h18.4c2.4.1 4.3 2 4.3 4.4zM64 94.9c-15.1 0-27.3-12.3-27.3-27.3C36.7 52.5 49 40.3 64 40.3s27.3 12.3 27.3 27.3S79.1 94.9 64 94.9zm0-52.6c-13.9 0-25.3 11.3-25.3 25.3C38.7 81.5 50 92.9 64 92.9s25.3-11.3 25.3-25.3S77.9 42.3 64 42.3zM42.9 67.6c0-11.7 9.5-21.1 21.1-21.1S85.1 56 85.1 67.6 75.7 88.7 64 88.7s-21.1-9.5-21.1-21.1z"></path><path id="icon-fireworks:4_4_" class="icon-fireworks" d="M109.7 1.5l-.6-.4C106-1 101.8-.1 99.7 2.9V3c-.1-.2-.3-.3-.5-.5-.9-.6-2.3-.4-2.9.6l-.7 1c-.6 1-.4 2.3.6 2.9l.6.3-2.1 3.1c-.1-.2-.3-.3-.5-.5-1-.6-2.3-.4-2.9.6l-.7 1.1c-.6 1-.4 2.3.6 2.9l.6.3-2.6 3.8c-1.2 1.7-1.4 3.8-.9 5.7L65.8 57.9c-5.5-2.5-14.6-4.9-18.9 4.4-6.3 13.7-6.4 15.5-16.7 19.4-10.3 3.9-19.2 16.6-12.7 29.6 3 6 9.1 9.7 10.8 10.7 1.5 1.2 7.2 5.4 13.9 5.9 14.5 1.1 23-11.9 22.7-22.9-.3-11 1.3-11.7 11.7-22.8 6.8-7.3 1.7-14.6-2.7-18.8l22.7-33.8c0-.1.1-.1.1-.2 1.7-.3 3.2-1.3 4.2-2.8l2.5-3.8c.9.5 2.1.2 2.7-.7l.7-1c.6-.9.4-2.1-.4-2.8l2-2.9c.9.5 2.1.2 2.7-.7l.7-1.1c.6-.9.4-2.1-.4-2.8 2.2-3 1.4-7.2-1.7-9.3zm-8.4 8.4l1 .6L61.5 71l-1.3-.5m2.9 1.6L54.4 85c-.3-.1-.6-.3-.9-.5-.3-.2-.5-.4-.8-.6l8.7-13c.3.1.6.3.8.5.4.3.7.5.9.7zm-11.7 1.5c2-2.9 5.6-4.1 8.8-3.1l-8.4 12.4c-2.1-2.6-2.4-6.4-.4-9.3zm3 11.4l.8.6L46.8 98l4.3 2.9c1.4.9 1.8 2.9.8 4.3-.5.7-1.2 1.1-2 1.3-.8.2-1.6 0-2.3-.5l-12.4-8.4c-1.4-.9-1.8-2.9-.9-4.3.5-.7 1.2-1.2 2-1.3.8-.2 1.6 0 2.3.5l4.4 3 8.6-12.7 1 1-8.5 12.5 1.8 1.1m18.6-15c-2 2.9-5.5 4.1-8.7 3.2l8.3-12.4c2.1 2.5 2.3 6.3.4 9.2zm39.6-70.6l1 .6-41 60.8-1-1"></path><path id="icon-fireworks:3_4_" class="icon-fireworks" d="M54.8 71.7l-24 1.4 3.6-14.4 20.4 13zM17.2 128l16.3-13.2-13.2.8-3.1 12.4zm6.2-24.7l-2 8.1 17.6-1 10.7-8.7-26.3 1.6zm3.3-13.4l-2.3 9.3L55 97.4l12.1-9.8-40.4 2.3zm34-14.5l-30.9 1.8-2.1 8.5 44.9-2.6.1-.1-12-7.6zm-9.2-14.2c.1-1.4 2-34.3-16-44.2l-2 3.6c15.7 8.7 13.9 40 13.9 40.4l4.1.2zm57.8-5l1.5-3.8c-11.9-4.6-42.1 15.5-45.5 17.8l2.3 3.4c8.7-6 33.3-20.7 41.7-17.4zM58.8 66.4c.1-.4 10.2-32.2 23.5-46.5l-3-2.8c-14 15-24.1 46.7-24.5 48l4 1.3zM43.2 49.1l-3.1-8.9-8.9 3.1 3.1 8.9 8.9-3.1zm36.8 29l-1.8-5.2 5.2-1.8 1.8 5.2-5.2 1.8zm-6.8-22l-1.8-5.2 5.2-1.8 1.8 5.2-5.2 1.8zM56.6 34.3L54.7 29l5.2-1.8 1.8 5.2-5.1 1.9zm7.6-27.2l-1.8-5.2L67.6 0l1.8 5.2-5.2 1.9zm32.7 36.8l-1.8-5.2 5.2-1.8 1.8 5.2-5.2 1.8z"></path><path id="icon-fireworks:2_4_" class="icon-fireworks" d="M28.9 128c-.9-.3-21.2-8.9-20.9-39 .1-4.8 1.3-8.9 3.5-12-.4-.6-.8-1.3-1.1-2-4.3-8.2-6.1-17-4.9-24.8 1-6.2 4.5-10.4 9.9-11.9-.4-14.7 2.2-31.7 2.3-32.6l4.7.7c0 .2-2.6 17-2.3 31.4 7.5.1 15.2 4.6 17.2 10.3.7 2.1 1.7 7.4-5.4 12.1-2.1 1.4-4.7 1.6-7.3.5-3.9-1.6-7-5.9-8.1-11.1-.4-2-.7-4.1-.9-6.3-2.5 1-4.8 3.1-5.5 7.7C9 58.8 11.3 67 15 73.5c1.3-1 2.8-1.7 4.4-2.2 6.8-2.2 15.1-.1 18.7 4.8 2.4 3.2 2.4 7.2-.1 10.8-3 4.3-7.6 5.6-12.6 3.5-3.8-1.5-7.6-4.8-11-9.2-1 1.9-1.6 4.4-1.7 7.8-.3 26.8 17.2 34.3 18 34.6l-1.8 4.4zM17.5 77.5c3 4.2 6.5 7.3 9.6 8.5 3 1.2 5.3.6 7-1.9 1.3-1.9 1.4-3.7.2-5.3-2.1-2.9-8.2-4.8-13.5-3.1-1.1.4-2.2 1-3.3 1.8zm2.9-34.9c.2 2.2.4 4.2.8 6.1.9 4.5 3.4 6.9 5.3 7.7.8.3 1.9.6 2.9-.1 3.1-2.1 4.3-4.3 3.5-6.6-1.3-3.7-7.2-6.9-12.5-7.1zm38.2-32.2H47.7l8.8 6.4-3.4 10.4 8.8-6.4 8.8 6.4-3.4-10.4 8.8-6.4H65.3L62 0l-3.4 10.4zm50.3 17.1h-6l4.9 3.5-1.9 5.7 4.9-3.5 4.9 3.5-1.9-5.7 4.9-3.5h-6l-1.9-5.7-1.9 5.7zM56.7 43.8c-5.2 0-9.4 4.2-9.4 9.4s4.2 9.4 9.4 9.4 9.4-4.2 9.4-9.4-4.2-9.4-9.4-9.4zm11 28.2c-3.5 0-6.4 2.9-6.4 6.4s2.9 6.4 6.4 6.4 6.4-2.9 6.4-6.4-2.8-6.4-6.4-6.4zm48.8-20.4c-3.5 0-6.4 2.9-6.4 6.4s2.9 6.4 6.4 6.4 6.4-2.9 6.4-6.4-2.9-6.4-6.4-6.4zm-36.3 73c-8.9-14.3-1.8-19.4 8.9-27.1 4.4-3.1 9.3-6.7 13.4-11.3 3.3-3.7 4.7-7.9 4.4-12.8-1.1-13.9-17.6-27.3-18.3-27.9l-3 3.7c.2.1 15.6 12.7 16.5 24.6.3 3.5-.8 6.5-3.2 9.2-3.8 4.2-8.3 7.4-12.7 10.6-10.4 7.6-21.2 15.4-10 33.5l4-2.5z"></path><path id="icon-fireworks:1_4_" class="icon-fireworks" d="M83.5 65.1C83.2 53.2 79 51.5 76.4 48c-2.4-3.3-4.8-34.6-5-37.4-.1-.1 0-.2 0-.2v.2c.1.1.3 0 .8-.6.7-.8-.1-4.1-.5-5.8h.6V0H55.8v4.3h.6c-.5 1.7-1.3 5-.5 5.8.6.6.8.7.8.6v-.2.2c-.2 2.8-2.6 34-5 37.4-2.6 3.5-6.8 5.1-7.1 17.1-.2 9.5-.1 43.6 0 57.2 0 3.1 2.6 5.7 5.7 5.7h27.6c3.1 0 5.7-2.5 5.7-5.7 0-13.7.1-47.8-.1-57.3zM79 108.3H49.1V70.2H79v38.1z"></path></g><g id="row1"><path id="icon-fireworks:5" class="icon-fireworks" d="M55.6 60.5l28.8 10.6c-2 1.9-4.6 3.4-7.4 4.1-6.6 18.3-21.4 48.1-26.4 51.3-1.5 1-3.8 1.5-5.6 1.5-1.3 0-2.5-.3-3.6-.8-6.1-2.9-9.8-13.5-11-31.6-.4-6.6-2.1-10.7-5.1-12-4.2-1.9-10.5 1.9-12.6 3.5l-1.9-2.4c.4-.3 9-7 15.7-3.9 4.1 1.9 6.5 6.8 7 14.6 1 16.4 4.3 26.8 9.2 29 3.9 1.8 7.4-1.2 7.4-1.2s6.4-38.4 10.2-52.8c-2.6-2.6-4.3-6.1-4.7-9.9zm17-19.1c-9 0-16.4 6.9-17.1 15.8l31.1 11.4c2-2.8 3.2-6.3 3.2-10 0-9.5-7.7-17.2-17.2-17.2zm37.4 0h7.1s-2-.6-5.1-6.3c-3.1-5.7-5.1-12.4-5.1-12.4v23.8c-.9-.5-1.9-.8-2.9-.8-3.4 0-6.1 2.7-6.1 6.1 0 3.3 2.7 6.1 6.1 6.1 3.3 0 6.1-2.7 6.1-6.1 0-.4-.1-10.4-.1-10.4zm-72.7 0h7.1s-2-.6-5.1-6.3c-3.1-5.7-5.1-12.4-5.1-12.4v23.8c-.9-.5-1.9-.8-2.9-.8-3.4 0-6.1 2.7-6.1 6.1 0 3.3 2.7 6.1 6.1 6.1 3.3 0 6.1-2.7 6.1-6.1 0-.4-.1-10.4-.1-10.4zM71.5 0c-6.1 0-11.1 5-11.1 11.1s5 11.1 11.1 11.1 11.1-5 11.1-11.1S77.6 0 71.5 0z"></path><path id="icon-fireworks:4" class="icon-fireworks" d="M55.2 82.5l5.7 8.9H54V128h-3.9V91.4h-6.9l5.7-8.9c-11.6-2-20.6-15.4-20.6-31.6C28.4 33.3 39 19 52.1 19c13.1 0 23.7 14.3 23.7 31.9 0 16.2-9 29.5-20.6 31.6zm44.4-14.1V9.3c0-2.5-1-4.9-2.7-6.6C95.2 1 92.9 0 90.3 0 85.2 0 81 4.2 81 9.3v59.1c0 4 2.5 7.4 6 8.7l-5.8 9h6.9v36.6H92V86.1h7l-5.7-8.9c3.6-1.2 6.3-4.7 6.3-8.8z"></path><path id="icon-fireworks:3" class="icon-fireworks" d="M128 91.6v9.5H50.2v-6.7C35.4 93.9 16.3 91 7.7 80.2 1.7 72.7-1 63 .3 53.7c1.2-8.9 5.9-16.5 13.1-21.5 6.2-4.3 13.7-6 21.1-4.7 7.4 1.3 13.9 5.4 18.3 11.6 3.6 5.1 5 11.3 3.9 17.4-1.1 6.2-4.5 11.5-9.6 15.1-8.9 6.2-23.5 3.9-29.5-4.7-5.1-7.4-3.4-17.5 4-22.7 6.4-4.5 17.3-2.8 21.7 3.3 1.8 2.6 2.5 5.7 2 8.8-.5 3.1-2.2 5.8-4.8 7.6-4.6 3.2-10.9 2.1-14.2-2.5l6.1-4.3c.9 1.2 2.5 1.5 3.8.7 1.9-1.4 2.4-4.1 1-6-1.9-2.7-8.3-3.6-11.2-1.5-4 2.8-4.9 8.3-2.1 12.3 3.7 5.3 13.6 6.8 19.1 2.9 3.5-2.4 5.8-6.1 6.5-10.2.7-4.2-.2-8.4-2.7-11.9-3.2-4.6-7.9-7.6-13.4-8.5-5.5-1-11 .3-15.5 3.5-5.5 3.8-9 9.7-10 16.5-1 7.4 1 14.9 5.8 20.8 6.6 8.2 22.8 10.9 36.7 11.4v-7.8h52s2.2 7.4 11.6 11.2c5.4 2.1 14 1.1 14 1.1z"></path><path id="icon-fireworks:2" class="icon-fireworks" d="M114.9.1l-6.5-.1-24.7 38.8H13.1l42.4 37.5v6.2h3.4v37.6L44.6 128H81l-14.3-7.9V82.5H70v-6.2l16.9-14.9 25.5-22.6H90.9l24-38.7zM62.8 82.8l-.3-.2h.5l-.2.2zM96.1 45l-10.4 9.2H39.8L29.4 45h66.7z"></path><path id="icon-fireworks:1" d="M8.3 92.3l53.4-24.9-43.8 38.7-9.6-13.8zm106.8-65.1l-46.8 35 55.3-20.4-8.5-14.6zm-107 8.5l52.4 26.9L3 51.7l5.1-16zM125 80.2L68.6 64.6l50 31.2 6.4-15.6zM63.6 2.4l1.5 58.8L47 5.6l16.6-3.2zm16.9 123.7L67.2 69.3 63.8 128l16.7-1.9zm9.8-96.9L66.2 62.4 79.8 24l10.5 5.2zm-43.1 75.6L64 67.7 37.1 98.8l10.1 6zm45.7-4.5l-24.5-33L101 91.9l-8.1 8.4zM33.5 36.5l30.4 27.1-21.6-34.9-8.8 7.8zm-9.7 24.2l1.6 4.9h5.1l-4.2 3 1.6 4.9-4.2-3-4.2 3 1.6-4.9-4.2-3H22l1.8-4.9zm19.3 57.9h-4.8l3.9 2.8-1.5 4.5 3.9-2.8 3.9 2.8-1.5-4.5 3.9-2.8h-4.8l-1.5-4.5-1.5 4.5zm54.6-10h-4.5l3.6 2.6-1.4 4.3 3.6-2.6 3.6 2.6-1.4-4.3 3.6-2.6h-4.5l-1.4-4.3-1.2 4.3zm14.2-50h-5l4 2.9-1.5 4.7 4-2.9 4 2.9-1.5-4.7 4-2.9h-5l-1.5-4.7-1.5 4.7zM86.3 6.9h-6.9L85 11l-2.1 6.6 5.6-4.1 5.6 4.1L92 11l5.6-4.1h-6.9L88.6.3l-2.3 6.6zM18.9 8.1h-8.5l6.9 5-2.6 8.1 6.9-5 6.9 5-2.8-8.2 6.9-5h-8.5l-2.6-8-2.6 8.1z" fill="#141414"></path></g></svg>
            <p class="punchline">All done!<br>Keep it that way!</p>
          </div>
        </div>
      `);
    }
  });

  // Input handling
  const handleSpaces = (input) => {
    input.value = input.value.replace(/ +?/g, '');
  };

  const handleCommas = (input) => {
    input.value = input.value.replace(',', '.');
  };

  ['refnumber', 'accountnumber', 'billnumber', 'amount'].forEach(id => {
    const element = document.getElementById(id);
    if (element) {
      element.addEventListener('keyup', () => handleSpaces(element));
      element.addEventListener('focus', () => handleSpaces(element));
    }
  });

  document.querySelectorAll('#amount, .amount-big').forEach(element => {
    element.addEventListener('keyup', () => handleCommas(element));
  });

  // Copy to clipboard functionality
  document.querySelectorAll('.able-to-copy').forEach(element => {
    element.addEventListener('click', function() {
      const value = this.getAttribute('data-copy-to-clipboard');
      const temp = document.createElement('input');
      document.body.appendChild(temp);
      temp.value = value;
      temp.select();
      document.execCommand('copy');
      temp.remove();

      const message = document.createElement('div');
      message.className = 'message success';
      message.textContent = 'Tallessa!';
      this.appendChild(message);

      setTimeout(() => message.remove(), 2000);
    });
  });

  // Modal handling
  document.querySelectorAll('.add-new-bill').forEach(btn => {
    btn.addEventListener('click', () => {
      document.body.classList.add('modal-opened');
      const modal = document.querySelector('.modal-bill-new');
      document.body.appendChild(modal);
      modal.style.display = 'block';
      modal.classList.add('show');
      document.querySelector('.bill-title').textContent = 'Uusi lasku';
    });
  });

  document.querySelectorAll('.bills-list .row-clickable').forEach(row => {
    row.addEventListener('click', function() {
      const rowId = this.getAttribute('data-row-id');
      document.body.classList.add('modal-opened');
      const modal = document.querySelector(`.modal-bill-${rowId}`);
      document.body.appendChild(modal);
      modal.style.display = 'block';
      modal.classList.add('show');
    });
  });

  // Close modal handlers
  document.addEventListener('keyup', (e) => {
    if (e.key === 'Escape') {
      document.body.classList.remove('modal-opened');
      document.querySelectorAll('.modal-bill, .modal').forEach(modal => {
        modal.classList.remove('show');
      });
    }
  });

  document.addEventListener('click', (e) => {
    if (e.target.matches('.show .modal-overlay')) {
      document.body.classList.remove('modal-opened');
      document.querySelectorAll('.modal-bill, .modal').forEach(modal => {
        modal.classList.remove('show');
      });
    }
  });

  // Date and amount formatting
  const formatDates = () => {
    document.querySelectorAll('.formatted-duedate').forEach(element => {
      const formattedDate = element.textContent;
      const now = Date.now();
      const d = moment(formattedDate, "YYYY-MM-DD H:i:s");
      element.innerHTML = d.fromNow();
      element.classList.add(d > now ? 'future' : 'past');
    });
  };

  const colorAmounts = (selector, ranges) => {
    document.querySelectorAll(selector).forEach(element => {
      const formattedAmount = parseInt(element.textContent);
      const amount = element.closest('.amount');

      ranges.forEach(({min, max, className}) => {
        if ((!max && formattedAmount >= min) ||
            (formattedAmount >= min && formattedAmount <= max)) {
          element.classList.add(className);
          if (amount) amount.classList.add(className);
        }
      });
    });
  };

  // Initialize formatting
  formatDates();
  colorAmounts('.formatted-amount', [
    { min: 0, max: 30, className: 'color-low' },
    { min: 30, max: 40, className: 'color-medium' },
    { min: 40, className: 'color-high' }
  ]);
  colorAmounts('.formatted-amount-high', [
    { min: 0, max: 80, className: 'color-low' },
    { min: 80, max: 150, className: 'color-medium' },
    { min: 150, className: 'color-high' }
  ]);
});

/**
 * Function that works to shorten the syntax to do query-selecting
 * @param {string} selector 'The selector as a string'
 * @param {element} scope 'The scope in which the selector is supposed to find results'
 */
export function qs (selector, scope) {
  return (scope || document).querySelector(selector);
};

/**
 * Function that works to shorten the syntax to do query-selecting for several elements
 * @param {string} selector 'The selector as a string'
 * @param {element} scope 'The scope in which the selector is supposed to find results'
 */
export function qsa (selector, scope) {
  return (scope || document).querySelectorAll(selector);
};

/**
 * Function to make event listener binding more convenient.
 * @param {element} target 'The element that should get the event listener'
 * @param {string} type 'What type of event listener to bind to the target'
 * @param {function} callback 'The callack function to be executed when the event is triggered'
 * @param {boolean} capture  A Boolean indicating that events of this type will be dispatched to the registered listener before being dispatched to any EventTarget beneath it in the DOM tree."
 */
export function on (target, type, callback, capture) {
  if (!target) return;
  target.addEventListener(type, callback, !!capture);
};

/**
 * Function to bind event and delegate a specific event handler to when an event is triggered.
 * @param {element} target 'The element that should get the event listener'
 * @param {string} selector 'The selector as a string to delegate the event binding to'
 * @param {string} type 'What type of event listener to bind to the target'
 * @param {function} handler 'The handler function to be executed when the event is triggered'
 * @param {boolean} capture  A Boolean indicating that events of this type will be dispatched to the registered listener before being dispatched to any EventTarget beneath it in the DOM tree."
 */
export function delegate (target, selector, type, handler, capture) {
  const fireEvent = (event) => {
    const targetElement = event.target;
    const potentialMatches = qsa(selector, target);
    const containsMatch = Array.prototype.indexOf.call(potentialMatches, targetElement) >= 0;

    if (containsMatch) {
      handler.call(targetElement, event)
    }
  };

  on(target, type, fireEvent, !!capture);
};
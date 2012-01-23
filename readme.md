# WebCards

## Premise (Elevator Pitch)

- Sending e-cards for various occasions.
- Internet application (rather than intranet or extranet)

## Existing Functionality

- 'Demo a WebCard' screen has been built; allows users to demo an e-card from a limited set of options.
- Demo displays in a new browser window and cookies hold the data entered and user selections.
- JavaScript is used for data validation.
- Button for 'Demo a WebCard' is generated via JavaScript and inserted into the DOM so that users with JavaScript disabled will not see the button.

## Additional Specifications

- You will need to write content for the 'Home', 'Features', 'Pricing', and 'Support' pages.
- Generate the copyright information via server-side scripting so it auto-updates when a new year arrives.
- Start gathering and/or creating graphics for the various WebCard themes (e.g., Holidays, Sympathy, Thank You, Love, etc.)
- 'Purchase a WebCard' and 'Create an Account' will be forms.
  - You will likely need to make these multiple-page processes (the user needs to build the WebCard, after all; also consider if the user can choose to purchase a WebCard that they built as a demo).
  - You also need to decide how the screens are related and interact with each other.
  - Make sure that the 'Purchase a WebCard' and 'Create an Account' forms are saving data properly.
  - Allow users to edit their account information.
  - Also allow users to edit and delete their WebCards.
- Determine a publishing strategy for WebCards and implement that strategy.
  - Where will they be available?
  - How long will they be available?
  - How will the parties involved be notified of the availability?
- Implement a contact form; this could be part of 'Support' or be a separate global navigation item.
  - Construct an admin screen that is separate from the rest of the application for tracking the contact form submissions (perhaps displaying them in a data table).
const defineEmail = (arrayEmail) => {
    if (arrayEmail != null) {
        const emailMap = arrayEmail.map((ed) => ed["email"]); // Map array email and return only the email string
        const ee = emailMap.toString();
        return ee.trim();
    }
};

const defineContact = (arrayContact) => {
    if (arrayContact != null) {
        const contact = arrayContact.map((ed) => ed["contact_number"]);
        const cc = contact.toString();
        return cc.trim();
    }
};

export { defineEmail, defineContact };

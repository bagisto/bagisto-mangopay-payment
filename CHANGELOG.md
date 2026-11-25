# CHANGELOG for v2.5.0.0

#### This changelog consists the bug & security fixes and new features being included in the releases listed below.

**Changelog Symbols:**

- `+` Feature Added
- `!` Bug Fixed
- `*` Modification

# CHANGELOG for v2.5.0.0 (7 October, 2026) - *Release*

**`*`** Compatible with Bagisto v2.5.0 and Marketplace v2.5.0.x; the module version is bumped to v2.5.0.0.

**`!`** Fixed the quantity fields in the admin MangoPay refund table keeping their bottom margin; the class uses the Tailwind CSS 4 form (`mb-0!`) that the core admin build compiles.

**`*`** Renamed the module's hyphenated route names to snake_case, following core v2.5: `admin.mangopay.create_wallet`, `admin.mangopay.save_bank_details`, `admin.mangopay.save_bank_details.store`, `admin.mangopay.release_amount` and `mangopay.standard.redirect_mangopay`. URLs are unchanged.

**`*`** Renamed the module's underscored translation keys to kebab-case, following core v2.5: `admin.mangopay.configuration.sort-order`, `admin.system.mangopay-refund` and the `admin.datagrid` `order-id`, `wallet-id`, `escrowed-amount`, `created-at` and `transaction-id` keys.

**`!`** Fixed the wallet creation, bank details save and escrow release actions in the admin MangoPay area skipping the role permission check; each is now mapped to the ACL key of the page it belongs to.

**`!`** Fixed the checkout, cancel and escrow release messages and the payment method settings description showing in English in every locale; they are now translated in all 22 locales.

**`!`** Fixed the MangoPay return page placing a paid order without asking MangoPay. The order is now placed only for the PayIn this checkout started, once the MangoPay API reports it as succeeded into the buyer's wallet for the cart's full base total; a failed, replayed or forged return places no order, and the same PayIn can place only one order.

**`!`** Fixed customers browsing in a currency other than the base currency being charged the display-currency total as a base-currency amount; the card payment and the escrowed amount now use the base grand total.

**`!`** Fixed the escrow release on orders shared by the admin and several sellers: sellers of offers on admin products were not paid, a seller with several items was paid once per item, and shipping stayed in the buyer's wallet. Each approved seller is now paid their unpaid payout once, less their share of refunds, and recorded as a Marketplace payout; the remainder goes to the admin wallet. A refused transfer stops the release, and releasing again never pays a seller twice.

**`!`** Fixed MangoPay refunds sending the adjustment refund and fee twice to MangoPay. Refund shipping is now capped like core's refund, items of another order are rejected, an order whose escrow was released is not refunded from another order's funds, and one refund of an order runs at a time.

**`!`** Fixed the MangoPay refund form and its save being refused for custom admin roles; they are mapped to the new ACL key `marketplace.mangopay.refund`.

**`!`** Fixed the admin wallet being created, and the existing one replaced, by a plain link that any page could trigger; it is now a form posted with a CSRF token.

**`!`** Fixed the admin and seller bank details forms saving posted `admin_id` / `seller_id` values; only the bank fields are saved, for the signed-in admin or seller.

**`!`** Fixed seller KYC uploads accepting any file and keeping identity documents on the public disk; uploads must be a PDF, JPEG or PNG of one of MangoPay's document types and are stored on the private disk.

**`!`** Fixed the MangoPay SDK caching its OAuth token under the publicly served `storage/app/public`; it now uses `storage/app/mangopay`.

**`!`** Fixed a non-numeric id on the escrow release and refund routes failing with a server error instead of not being found.

**`!`** Fixed the admin refund summary panel and the seller bank details and KYC forms losing their width; they use widths the Tailwind CSS 4 builds compile.

**`+`** Added a MangoPay hook endpoint (`GET mangopay/webhook`) for `PAYIN_NORMAL_SUCCEEDED` / `PAYIN_NORMAL_FAILED`: a customer who closes the browser after 3-D Secure still gets the order, placed with the same checks as the return page after reading the PayIn back from the MangoPay API. See the README's "Webhook setup".

**`!`** Fixed a card payment being kept when its order could not be placed (for example when stock ran out meanwhile or the cart changed): the PayIn is now refunded to the card.

**`!`** Fixed the admin wallet belonging to the admin user who created it: the store now has one admin wallet and bank account that every permitted admin uses, **Create Wallet** no longer replaces an existing wallet, and deleting an admin hands the wallet over instead of deleting it.

**`!`** Fixed deleting a customer's first cart deleting the customer's MangoPay wallet record, which later broke the escrow release of orders paid from it.


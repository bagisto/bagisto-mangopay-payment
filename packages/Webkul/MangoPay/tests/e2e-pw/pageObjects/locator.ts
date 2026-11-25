import { Locator, Page, expect } from "@playwright/test";

export class WebAllLocators {
    readonly page: Page;

    readonly addSellerButton: Locator;
    readonly emailInput: Locator;
    readonly slugInput: Locator;
    readonly createSellerSaveButton: Locator;
    readonly successToast: Locator;
    readonly backButton: Locator;
    readonly sellerCheckbox: Locator;
    readonly selectActionDropdown: Locator;
    readonly updateStatusOption: Locator;
    readonly approvedOption: Locator;
    readonly agreeButton: Locator;
    readonly updateSuccessToast: Locator;
    readonly passwordInput: Locator;
    readonly confirmPasswordInput: Locator;

    readonly editButton: Locator;
    readonly sellerNameInput: Locator;
    // readonly sellerDescriptionInput: Locator;
    readonly sellerMetaTitleInput: Locator;
    readonly sellerMetaDescriptionInput: Locator;
    readonly sellerMetaKeywordsInput: Locator;
    readonly sellerSaveButton: Locator;
    readonly sellerDescriptionIframe: string;
    readonly sellerPhoneNumber: Locator;

    readonly address: Locator;
    readonly addressCity: Locator;
    readonly addressCountry: Locator;
    readonly addressState: Locator;
    readonly addressZip: Locator;
    readonly commissionToggle: Locator;
    readonly commissionInput: Locator;
    readonly productType: Locator;
    readonly businessName: Locator;

    /**
     * Create Attribute for Seller locators initialization
     */
    readonly createSellerAttributeButton: Locator;
    readonly attributeType: Locator;
    readonly attributeCode: Locator;
    readonly visibleOnSignUp: Locator;
    readonly visibleOnProfile: Locator;
    readonly visibleOnPublic: Locator;
    readonly adminLabel: Locator;
    readonly engLabel: Locator;

    readonly saveAttributeButton: Locator;
    readonly attributeSuccessToast: Locator;

    /**
     * Create Flag Reason locators initialization
     */
    readonly createFlagButton: Locator;
    readonly reasonTypeDropdown: Locator;
    readonly flagStatusToggle: Locator;
    readonly saveButton: Locator;
    readonly flagSuccessToast: Locator;

    /**
     * Allow Products type to Seller locators initialization
     */
    readonly searchSellerInput: Locator;
    readonly allowSellerSaveButton: Locator;

    /**
     * Seller register from front side
     */
    readonly sellerLoginButton: Locator;
    readonly registerButton: Locator;
    readonly sellerCreateSuccessToast: Locator;
    readonly loginSuccess: Locator;

    /**
     * Seller create Product
     */
    readonly createProductButton: Locator;
    readonly selectProductType: Locator;
    readonly selectAttribute: Locator;
    readonly productSku: Locator;
    readonly clickContinueButton: Locator;
    readonly createProductSuccessToast: Locator;
    readonly productName: Locator;
    readonly productShortDescription: string;
    readonly productDescription: string;
    readonly productPrice: Locator;
    readonly productWeight: Locator;
    readonly productInventory: Locator;
    readonly clickSaveProduct: Locator;
    readonly updateProductSuccessToast: Locator;

    /**
     * Create Seller Users and Roles Locator initialization
     */

    readonly clickCreateRoleButton: Locator;
    readonly permissionType: Locator;
    readonly roleName: Locator;
    readonly roleDescription: Locator;
    readonly clickSaveRoleButton: Locator;
    readonly roleCreateSuccessToast: Locator;

    readonly clickCreateUserButton: Locator;
    readonly userName: Locator;
    readonly userEmail: Locator;
    readonly userPassword: Locator;
    readonly userConfirmPassword: Locator;
    readonly selectUserRole: Locator;
    readonly userStatus: Locator;
    readonly userPhoneNumber: Locator;
    readonly saveUserbutton: Locator;
    readonly createUserSuccessToast: Locator;

    /**
     * Marketplace Product settings conditaion Locators
     */
    readonly productApproval: Locator;
    readonly sellerCanAssignInput: Locator;
    readonly sellerCanCreateInput: Locator;
    readonly showProgressBarInput: Locator;
    readonly productFlagInput: Locator;

    /**
     * Admin product create locator
     *
     */
    readonly adminProductCreateButton: Locator;
    readonly adminClickSaveProductButton: Locator;
    readonly adminProductInventory: Locator;

    /**
     *
     * @param page Seller assign admin product
     */
    readonly searchAdminProduct: Locator;
    readonly clickSuggestProduct: Locator;
    readonly productCondition: Locator;
    readonly assignQuantity: Locator;
    readonly descriptiontextarea: Locator;
    readonly assignSuccessToast: Locator;
    readonly clickAssignSaveButton: Locator;

    /**
     *
     * @param page Mass approval locators
     */
    readonly massCheckbox: Locator;
    readonly clickSelectActionButton: Locator;
    readonly updateStatus: Locator;
    readonly clickApprovedButton: Locator;
    readonly clickAgreeButton: Locator;
    readonly approvedSuccessToast: Locator;

    /**
     * Minimum order amount
     */
    readonly sellerMinimumOrderAmount: Locator;

    /**
     * click save profile button
     */
    readonly sellerProfileSaveButton: Locator;
    readonly sellerprofileUpdateToast: Locator;

    /**
     *
     * @param page Checkout process locators
     */
    readonly addToCartButton: Locator;
    readonly ShoppingCartIcon: Locator;
    readonly ContinueButton: Locator;
    readonly companyName: Locator;
    readonly firstName: Locator;
    readonly lastName: Locator;
    readonly shippingEmail: Locator;
    readonly streetAddress: Locator;
    readonly billingCountry: Locator;
    readonly billingState: Locator;
    readonly billingCity: Locator;
    readonly billingZip: Locator;
    readonly billingTelephone: Locator;
    readonly clickProcessButton: Locator;
    readonly choosePaymentMethod: Locator;
    readonly chooseMoneyBankMethod:Locator;
    readonly chooseStripePaymentMethod:Locator;
    readonly chooseShippingMethod: Locator;
    readonly clickPlaceOrderButton: Locator;
    readonly clickSaveAddressButton: Locator;

    /**
     * Customer register and login locators
     */
    readonly customerFirstName: Locator;
    readonly customerLastName: Locator;
    readonly customerPassword: Locator;
    readonly customerConfirmPassword: Locator;
    readonly customerEmail: Locator;
    readonly customerRegisterButton: Locator;
    readonly customerRegisterSuccessToast: Locator;
    readonly customerLoginButton: Locator;

    /**
     * contact to seller locators initialization
     */
    readonly sellerProfileLinkClick: Locator;
    readonly updateSellerProfileToast: Locator;
    readonly contactToSellerPhoneIcon: Locator;
    readonly contactToSellerName: Locator;
    readonly contactToSellerEmail: Locator;
    readonly contactToSellerSubject: Locator;
    readonly contactToSellerQuery: Locator;
    readonly contactToSellerSubmitButton: Locator;
    readonly contactToSellerSuccessToast: Locator;

    /**
     * Report seller profile locators initialization
     */
    readonly sellerReportIssueIcon: Locator;
    readonly reportIssueReason: Locator;
    readonly reportIssueSubmitButton: Locator;
    readonly reportProfileSuccessToast: Locator;
    readonly searchInput: Locator;
    readonly clickTotalSellerFlagsButton: Locator;
    readonly reportProductSuccessToast: Locator;
    readonly clickTotalFlagsButton: Locator;

    readonly reportProductReason: Locator;

    /**
     * Review seller product locators initialization
     */

    readonly reviewTabButton: Locator;
    readonly writeAReviewButton: Locator;
    readonly reviewRating: Locator;
    readonly writeAReviewTitle: Locator;
    readonly writeAReviewComments: Locator;
    readonly submitReviewButton: Locator;
    readonly productReviewSuccessToast: Locator;
    readonly profileReviewSuccessToast: Locator;
    readonly profileReviewTabButton: Locator;
    readonly submitProfileReviewButton: Locator;

    readonly searchProductOnFront: Locator;
    readonly clickFirstProductOnsearchResult: Locator;

    readonly fillsellerProductReason: Locator;

    //RMA locators initialization
    readonly createReasonButton: Locator;
    readonly rmaReasonInput: Locator;
    readonly resolutionType: Locator;

    //RMA Rule locators initialization
    readonly createRuleButton: Locator;
    readonly rmaRuleInput: Locator;
    readonly rmaRuleDescription: Locator;
    readonly rmaExchangePeriodInput: Locator;
    readonly rmaReturnPeriodInput: Locator;

    //RMA Statuses locators initialization
    readonly createStatusButton: Locator;
    readonly rmaStatusInput: Locator;
    readonly rmaStatusColorInput: Locator;

    //RMA Custom Field locators initialization
    readonly rmaCustomFieldButton: Locator;
    readonly rmaCustomFieldInput: Locator;
    readonly rmaCustomFieldTypeDropdown: Locator;
    readonly rmaCustomFieldCodeInput: Locator;
    readonly rmaCustomFieldPositionInput: Locator;
    readonly rmaCustomFieldIsRequiredCheckbox: Locator;
    readonly rmaCustomFieldStatus: Locator;
    readonly rmaCustomFieldSaveButton: Locator;
    readonly rmaCustomFieldSuccessToast:Locator;

    /*
    * Seller Data Transfer locators initialization
    */
    readonly sellerDataTransferButton: Locator;
    readonly dataTransferTypeDropdown: Locator;


    constructor(page: Page) {
        this.page = page;
        this.addSellerButton = page.getByRole("button", {
            name: "Add Sellers",
        });
        this.emailInput = page.locator('input[name="email"]');
        this.slugInput = page.locator('input[name="slug"]');
        this.sellerNameInput = page.locator('input[name="name"]');
        this.passwordInput = page.locator('input[name="password"]');
        this.confirmPasswordInput = page.locator(
            'input[name="password_confirmation"]'
        );

        this.createSellerSaveButton = page.getByRole("button", {
            name: "Save",
        });
        this.successToast = page
            .locator("text=Seller Created Successfully.")
            .first();
        this.backButton = page.locator('//a[contains(.," Back ")]');
        this.sellerCheckbox = page.locator(
            '(//label[@class="icon-uncheckbox peer-checked:icon-checked cursor-pointer rounded-md text-2xl peer-checked:text-blue-600"])[1]'
        );
        this.selectActionDropdown = page.locator(
            '//button[contains(., "Select Action") ]'
        );
        this.updateStatusOption = page.locator(
            "//span[contains(.,'Update Status')]"
        );
        this.approvedOption = page.locator("//a[contains(.,'Approved')]");
        this.agreeButton = page.locator('//button[contains(.,"Agree")]');
        this.updateSuccessToast = page
            .locator("text=Seller Updated Successfully.")
            .first();

        this.updateSellerProfileToast = page.locator('Your Profile is updated successfully').first();

        this.editButton = page.locator('span[title="Edit"]').nth(0);
        this.sellerDescriptionIframe = "#business_description_ifr";
        this.sellerMetaTitleInput = page.locator('input[name="meta_title"]');
        this.sellerMetaDescriptionInput = page.locator(
            'textarea[name="meta_description"]'
        );
        this.sellerMetaKeywordsInput = page.locator(
            'input[name="meta_keywords"]'
        );
        this.sellerSaveButton = page.locator('//button[contains(.," Save ")]');
        this.sellerPhoneNumber = page.locator('input[name="phone"]');

        this.address = page.locator('textarea[name="address"]');
        this.addressCity = page.locator('input[name="city"]');
        this.addressCountry = page.locator('select[name="country"]');
        this.addressState = page.locator('select[name="state"]');
        this.addressZip = page.locator('input[name="postcode"]');
        this.commissionToggle = page.locator("div:nth-child(3) > .relative > label");
        this.commissionInput = page.locator(
            'input[name="commission_percentage"]'
        );
        this.productType = page.locator(
            'select[name="allowed_product_types[]"]'
        );
        this.businessName = page.locator('input[name="business_name"]');

        /**
         * Create Attribute for Seller locators
         */
        this.createSellerAttributeButton = page.locator(
            '//a[contains(.," Create Seller Attribute ")]'
        );
        this.adminLabel = page.locator('//input[@placeholder="Admin"]');
        this.engLabel = page.locator('//input[@placeholder="English"]');
        this.attributeCode = page.locator(
            'input[placeholder="Attribute Code"]'
        );
        this.visibleOnPublic = page.locator('#is_visible_on_public').nth(1);
        this.visibleOnSignUp = page.locator('#is_visible_on_sign_up').nth(1);
        this.visibleOnProfile = page.locator('#is_visible_on_profile').nth(1);
        this.attributeType = page.locator('select[id="type"]');
        this.saveAttributeButton = page.locator(
            '//button[contains(.," Save Seller Attribute ")]'
        );
        this.attributeSuccessToast = page
            .getByText("Seller Attribute Created Successfully")
            .first();

        /**
         * Create Flag Reason locators
         */
        this.createFlagButton = page.locator("a.primary-button");

        this.reasonTypeDropdown = page.locator('//select[@id="type"]');
        this.flagStatusToggle = page.locator(".relative > label");
        this.saveButton = page.locator("button.primary-button");
        this.flagSuccessToast = page
            .getByText("Flag Reason created successfully.")
            .first();

        /**
         * Allow Products type to Seller locators
         */

        this.searchSellerInput = page.locator('input[name="search"]').nth(0);
        this.allowSellerSaveButton = page
            .getByRole("button", { name: " Save Seller " })
            .nth(0);

        /**
         * Seller register from shopfront
         */
        this.registerButton = page.getByRole("button", { name: "Register" });
        this.sellerLoginButton = page.getByRole("button", { name: "Sign In" });
        this.sellerCreateSuccessToast = page
            .locator("text=Account created successfully.")
            .first();
        this.loginSuccess = page.locator(
            '//a[contains(.,"Complete Your Profile")]'
        );

        /**
         * Create seller Product from seller panel
         */
        this.createProductButton = page.locator("a.primary-button");
        this.createProductSuccessToast = page
            .getByText("Product created successfully")
            .first();
        this.selectProductType = page.locator('select[name="type"]');
        this.selectAttribute = page.locator(
            'select[name="attribute_family_id"]'
        );
        this.productSku = page.locator('input[name="sku"]');

        /**
         * Click to Continue button
         */
        this.clickContinueButton = page.locator(
            '//button[contains(.,"Continue")]'
        );

        /**
         * Fill the Product Name
         */
        this.productName = page.locator("#name");

        /**
         * Fill the Description and Short DEscription using the Function
         */
        this.sellerDescriptionIframe = "#business_description_ifr";

        this.productShortDescription = "#short_description_ifr";
        this.productDescription = "#description_ifr";

        /**
         * Enter the Price
         */
        this.productPrice = page.locator('//input[@name="price"]');

        /**
         * Enter the Weight
         */
        this.productWeight = page.locator('//input[@name="weight"]');

        this.productInventory = page.locator(
            '(//input[@class="w-full mb-0.5 py-2.5 px-3 border-2 rounded-lg text-sm text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400"])[4]'
        );

        /**
         * Click on the save button
         */
        this.clickSaveProduct = page.locator(
            '//button[contains(.,"Save Product") ]'
        );
        this.updateProductSuccessToast = page
            .getByText("Product updated successfully")
            .first();

        /**
         * Create seller User and Role
         */
        this.clickCreateRoleButton = page.locator(
            '//a[contains(.," Create Role ")]'
        );
        this.permissionType = page.locator('select[name="permission_type"]');
        this.roleName = page.locator('input[id="name"]');
        this.roleDescription = page.locator('textarea[name="description"]');
        this.clickSaveRoleButton = page.locator(
            '//button[contains(.," Save Role ")]'
        );
        this.roleCreateSuccessToast = page
            .locator("text =Role is created successfully")
            .first();

        this.clickCreateUserButton = page.locator(
            '//button[contains(.," Create User ")]'
        );
        this.userName = page.locator('input[name="name"]');
        this.userEmail = page.locator('input[placeholder="Email"]').nth(2); // Locator 3 [.nth(2)]
        this.userPhoneNumber = page.locator(
            'input[placeholder="Phone Number"]'
        );
        this.userPassword = page.locator('input[name="password"]');
        this.userConfirmPassword = page.locator(
            'input[name="password_confirmation"]'
        );
        this.selectUserRole = page.locator("#marketplace_role_id");
        this.userStatus = page.locator(".relative > label");
        this.saveUserbutton = page.locator('//button[contains(.,"Save User")]');
        this.createUserSuccessToast = page
            .locator("text =User created successfully")
            .first();

        /**
         * Marketplace Product settings
         */
        this.productApproval = page.locator(
            'input[id="marketplace[products][approval][approval_required]"]'
        );
        this.sellerCanAssignInput = page.locator(
            '//input[@id="marketplace[products][approval][seller_can_assign]"]'
        );
        this.sellerCanCreateInput = page.locator(
            '//input[@id="marketplace[products][approval][seller_can_create]"]'
        );
        this.showProgressBarInput = page.locator(
            '//input[@id="marketplace[products][form][show_progress_bar]"]'
        );
        this.productFlagInput = page.locator(
            '//input[@id="marketplace[moderation][product_flags][flag_enabled]"]'
        );

        /**
         * Create admin Product
         */
        this.adminProductCreateButton = page.locator("button.primary-button");
        this.adminClickSaveProductButton = page.locator(
            '//button[contains(.,"Save Product")]'
        );
        this.adminProductInventory = page.locator(
            'input[name="inventories[1]"]'
        );

        /**
         * Search admin Product and assign
         */
        this.searchAdminProduct = page.locator(
            'input[placeholder="Search Products"]'
        );
        this.clickSuggestProduct = page.locator(
            '//a[contains(.," Sell as Yours ")]'
        );
        this.assignQuantity = page
            .locator("input.text-sm.transition-all")
            .nth(1);
        this.productCondition = page.locator('select[name="condition"]');
        this.descriptiontextarea = page.locator('textarea[name="description"]');
        this.clickAssignSaveButton = page.locator(
            '//button[contains(.," Save ")]'
        );
        this.assignSuccessToast = page
            .locator("text= Product assigned successfully to the seller")
            .first();

        /**
         * Mass update locators:
         */
        this.massCheckbox = page.locator("span.icon-uncheckbox");
        this.clickSelectActionButton = page.locator(
            '//span[contains(.," Select Action ")]'
        );
        this.updateStatus = page.locator('//span[contains(.,"Update Status")]');
        this.clickApprovedButton = page.locator('//a[contains(.,"Approved")]');
        this.clickAgreeButton = page.locator('//button[contains(.,"Agree")]');
        this.approvedSuccessToast = page
            .locator("text = Product Updated successfully.")
            .first();

        this.sellerMinimumOrderAmount = page.locator(
            'input[name="min_order_amount"]'
        );

        this.sellerProfileSaveButton = page.locator(
            '//button[contains(.," Save Profile ")]'
        );

        this.sellerprofileUpdateToast = page
            .locator("text = Your Profile is updated successfully")
            .first();

        /**
         * Checkout process shipping address locator
         */
        this.addToCartButton = page.locator(
            "(//button[contains(@class, 'secondary-button')])[2]"
        );
        this.ShoppingCartIcon = page.locator(
            "(//span[contains(@class, 'icon-cart') and @role='button' and @tabindex='0'])[1]"
        );
        this.ContinueButton = page.locator(
            '(//a[contains(., " Continue to Checkout ")])[1]'
        );
        this.companyName = page.getByRole("textbox", { name: "Company Name" });
        this.firstName = page.getByRole("textbox", { name: "First Name" });
        this.lastName = page.getByRole("textbox", { name: "Last Name" });
        this.shippingEmail = page.getByRole("textbox", {
            name: "email@example.com",
        });
        this.streetAddress = page.getByRole("textbox", {
            name: "Street Address",
        });
        this.billingCountry = page.locator('select[name="billing\\.country"]');
        this.billingState = page.locator('select[name="billing\\.state"]');
        this.billingCity = page.getByRole("textbox", { name: "City" });
        this.billingZip = page.getByRole("textbox", { name: "Zip/Postcode" });
        this.billingTelephone = page.getByRole("textbox", {
            name: "Telephone",
        });
        this.clickSaveAddressButton = page.getByRole("button", {
            name: "Save",
        });
        this.clickProcessButton = page.getByRole("button", { name: "Proceed" });
        this.chooseShippingMethod = page.getByText("Free Shipping").first();
        this.choosePaymentMethod = page.getByText("Stripe Payment Method").first();
        this.chooseStripePaymentMethod=page.getByText("Stripe Payment").first();
        this.chooseMoneyBankMethod = page.getByText("Money Transfer").first();
        this.clickPlaceOrderButton = page.getByRole("button", {
            name: "Place Order",
        });

        this.customerFirstName = page.getByRole("textbox", {
            name: "First Name",
        });
        this.customerLastName = page.getByRole("textbox", {
            name: "Last Name",
        });
        this.customerEmail = page.getByRole("textbox", {
            name: "Email",
        });
        this.customerPassword = page.locator('input[name="password"]');
        this.customerConfirmPassword = page.locator(
            'input[name="password_confirmation"]'
        );
        this.customerRegisterButton = page.getByRole("button", {
            name: "Register",
        });
        this.customerRegisterSuccessToast = page
            .locator(
                "text= Account created successfully."
            )
            .first();
        this.customerLoginButton = page.getByRole("button", {
            name: "Sign In",
        });

        /**
         * Contact to seller locators
         */
        this.sellerProfileLinkClick = page.locator("a.text-navyBlue.text-lg");
        this.contactToSellerPhoneIcon = page.locator("span.mp-phone-icon");
        this.contactToSellerName = page.locator('input[name="name"]');
        this.contactToSellerEmail = page.locator('input[name="email"]').nth(0);
        this.contactToSellerSubject = page.locator('input[name="subject"]');
        this.contactToSellerQuery = page.locator('textarea[name="query"]');
        this.contactToSellerSubmitButton = page.getByRole("button", {
            name: "Submit",
        });
        this.contactToSellerSuccessToast = page
            .locator("text=Your query has been submitted successfully")
            .first();

        /**
         * Report seller profile locators
         */
        this.sellerReportIssueIcon = page.locator(
            "span.mp-issue-icon.text-2xl"
        );
        this.reportIssueReason = page.locator('select[name="reason"]');
        this.reportIssueSubmitButton = page.getByRole("button", {
            name: "Submit",
        });
        this.reportProfileSuccessToast = page
            .locator("text=Seller reported successfully")
            .first();

        this.searchInput = page.locator('input[placeholder="Search"]').first();
        this.clickTotalSellerFlagsButton = page
            .locator("a.text-sm.text-blue-600.underline")
            .nth(1);
        this.reportProductSuccessToast = page
            .locator("text=Product Reported successfully")
            .first();
        this.clickTotalFlagsButton = page.locator(
            "a.text-sm.text-blue-600.underline"
        );
        this.reportProductReason = page.locator('select[placeholder="Reason"]');

        /**
         * Review seller product locators
         */
        this.reviewTabButton = page.locator("#review-tab-button");
        this.writeAReviewButton = page.locator("span.icon-pen.text-2xl").nth(0);
        this.reviewRating = page.locator("span.icon-star-fill.cursor-pointer");
        this.writeAReviewTitle = page.locator('input[name="title"]');

        this.rmaReasonInput = page.locator('input[name="title"]');
        this.resolutionType = page.locator('select[name="resolutions[]"]');

        this.rmaRuleDescription = page.locator('textarea[name="description"]');


        this.writeAReviewComments = page.locator('textarea[name="comment"]');
        this.submitReviewButton = page.getByRole("button", {
            name: "Submit Review",
        });
        this.productReviewSuccessToast = page
            .locator("text=Review submitted successfully.")
            .first();
        this.profileReviewSuccessToast = page
            .locator("text=Seller Reviewed successfully")
            .first();
        this.profileReviewTabButton = page
            .locator("button.rounded-xl.py-2")
            .nth(1);
        this.submitProfileReviewButton = page.getByRole("button", {
            name: "Submit",
        });

        this.searchProductOnFront = page.locator(
            '//input[@aria-label="Search products here"]'
        );
        this.clickFirstProductOnsearchResult = page.locator(
            '//div[@class="mt-8 grid grid-cols-3 gap-8 max-1060:grid-cols-2 max-md:mt-5 max-md:justify-items-center max-md:gap-x-4 max-md:gap-y-5"][1]/div[1]'
        );
        this.fillsellerProductReason = page
            .locator('select[placeholder="Reason"]')
            .nth(0);

        // RMA Reason create locators
        this.createReasonButton = page.locator(
            'button.primary-button'
        );

        // RMA Rule create locators
        this.rmaRuleInput = page.locator('input[name="title"]');

        this.createRuleButton = page.locator(
            'button.primary-button'
        );

        this.rmaExchangePeriodInput = page.locator(
            'input[name="exchange_period"]'
        );

        this.rmaReturnPeriodInput = page.locator(
            'input[name="return_period"]'
        );

        this.createStatusButton = page.locator(
            'button.primary-button'
        );

        this.rmaStatusInput = page.locator('input[name="title"]');

        this.rmaStatusColorInput = page.locator('input[name="color"]');

        // RMA Custom Field locators

        /**
         * Click onn the RMA Custom Field create button
         */
        this.rmaCustomFieldButton = page.locator(
            'a.primary-button'
        );

        this.rmaCustomFieldInput = page.locator('input[name="label"]');

        this.rmaCustomFieldTypeDropdown = page.locator(
            'select[name="type"]'
        );

        this.rmaCustomFieldCodeInput = page.locator('input[name="code"]');

        this.rmaCustomFieldPositionInput = page.locator(
            'input[name="position"]'
        );

        this.rmaCustomFieldIsRequiredCheckbox = page.locator(
            'label[id="is_required"]'
        );

        this.rmaCustomFieldStatus = page.locator(
            'label[for="status"]'
        );

        this.rmaCustomFieldSaveButton = page.locator(
            'button.primary-button'
        );

        this.rmaCustomFieldSuccessToast = page.locator('text=Custom Field created successfully.').first();

        /**
         * Seller Data Transfer locators
         */
        this.sellerDataTransferButton = page.locator('a.primary-button');
        this.dataTransferTypeDropdown = page.locator('select[name="type"]');

    }
}

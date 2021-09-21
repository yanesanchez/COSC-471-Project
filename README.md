# **COSC 471 Project: Best-Book-Buy Online Bookstore**

# **I. Project expectations**

a) Group of 2 students

b) Java GUI or PHP programming only (PHP is preferred)
Any deviations from these expectations will require instructor’s approval.

# II. Phases, deliverables, and due dates

## Phase 1: Front-end development

*15 points; Due Week 4*

### Deliverables:

- Team information
- Plans for development
    - Who will do what?
    - Where will the application be hosted?
- Link to the main page (index.html)
    - Complete GUI (all 12 screens) and
    functional links to appropriate web pages

## Phase 2: Conceptual database design & database connectivity

2*5 points; Due Week 8*

### Deliverables:

- ER diagram
- Completely functional figures 4 and 6
    - Create two dummy tables in the database
    and populate these pages with data from
    those tables
    - PHP/Java code

## Phase 3: Logical database design and database updates

*30 points; Due Week 11*

### Deliverables:

- Relational schema (of the updated ER diagram
from phase 2)
- DDL
    - Create table statements, including primary and foreign keys and other constraints
    - Create index statements (if appropriate)
- DML
    - Insert statements to create the initial database instance (each table should
    include at least 3 or more meaningful
    rows of data)
- Completely functional figures 1 through 6 including database reads and writes

## Phase 4: Implementation

*30 points; Week 14*

### Deliverables:

- Completed application
- Link to the main page (index.html)
- User and admin credentials (for testing)
- Individual contributions summary
- Demo

# III. Project Specifications

*Source: “Fundamentals of Database Systems” by Ramez Elmasri & Shamkanth Navathe* 

*Modified by: Dr. Krish Narayanan*

## 1. Introduction

Best-Book-Buy (3-B) is an information management system that supports some of the services
involved in an online bookstore, such as Amazon.com. The information system that is described here is a simplified version of a full-fledged online bookstore system. This document is to be treated as a complete set of specifications for this project for this class.

When the customer accesses 3-B.com, the first page that they see is depicted below. 

(see **Figure 1:** Welcome screen)

The rest of this document is organized as follows. We describe the operations and screens that a user will go through when one of the above options are selected. Then, we discuss some general aspects relevant to the system as a whole.

## 2. Search Only

Let’s say that the user only wants to search the bookstore for a specific book. She clicks “Search Only” and the screen in Figure 2 pops up. Internally, the system will create a temporary shopping cart for this new user. Briefly, a shopping cart is just a temporary structure in main memory that will hold the books that the user may decide to purchase while browsing [3-B.com](http://3-b.com/). The shopping cart is an important component of the system, and we defer more detailed discussion on this component to later in this document after presenting the main functionalities of the system.

(see **Figure 2:** Search screen)

The user enters some keywords in the “Search For” field, determines where these keywords should be examined (e.g., on the title of a book), and within which category. Commas will be used to separate the keywords. A category is the genre/type of the book, say, Fiction, Mystery, Horror, Youth, etc. By default, the system assumes that the user wants to search using “Keyword anywhere” over all categories. Alternately, the user may specify which attributes and category to search in. Multiple attributes may be selected, for example, Author, and Publisher. The Category drop-down list should list all categories that are included in the database at that point in time. The user either picks one category or searches over all categories. The search is executed by clicking the “Search” button. When the system finishes executing the search, the screen depicted in Figure 3 pops up.

Initially, the “Search” button is deactivated, and it will only be activated when the user enters some keywords in the “Search For” field. The search is conducted by checking whether the keywords provided appear anywhere in the field(s) indicated in “Search In.”

From the Search screen, the user may also decide to switch to her shopping cart or exit 3-B.com. If she decides to leave the system, her shopping cart is discarded and the Welcome screen (Figure 1) is displayed. We discuss later in the text the “Manage Shopping Cart” task.

Let us consider that the user is searching for books with the word “SQL” in the title. One possible result for this search is depicted in the Search Result screen shown in Figure 3. Books that are not in stock or that were deleted (see Section 5.1.2) cannot be shown in the search result.

(see **Figure 3:** Search Result screen)

In the Search Result screen, the user can perform the following activities:

- ***Add to Cart*** one or more books listed. By clicking on the “Add to Cart” button next to a book, the system inserts this book into the user’s shopping cart, disables the respective “Add to Cart” button, and updates the total number of items in the cart. If the user later decides that she does not want this book in her shopping, she can remove it by clicking on “Manage Shopping Cart” button.
- ***Review*** one or more books listed. By clicking on the “Review” button next to a book, the system brings up the Book Review screen (Figure 4), which displays a scrollable window that lists all the reviews for the selected book. By clicking the “Done” button on Book Review screen, the system brings back the Search Result screen (Figure 3).
- ***Manage Shopping Cart***, which allows the user to view the list of books in her shopping cart and modify this list accordingly. The interface for this option is depicted in Figure 5.
- ***Proceed to checkout***, which allows the user to place an order for the books in her shopping cart and make the payment. If she is a new user, then she needs to first register into the system. For that, the system will pop the screen from Figure 6. Otherwise, the screen from Figure 8 is displayed. We will describe the checkout process shortly.
- ***New Search*** brings back the Search screen.

(See **Figure 4:** Book Reviews Screen)

Let’s say that the user has selected both books listed in Figure 3, and she wants to manage her shopping cart. Upon clicking the “Manage Shopping Cart” button, the screen in Figure 5 will pop up.

(See **Figure 5:** Manage Shopping Cart screen)

From the Manage Shopping Cart screen, the user can remove one of the books from her cart and/or change the quantity of the selected books. The user can remove a book by clicking on the “Delete Item” button next to the book. The system then deletes the book, updates the cart accordingly, and recalculates the subtotal. 

The quantity of a book can be updated by directly clicking on the “Qty” field, and entering the new quantity. Then, the user must click on “Recalculate Payment” button so that the system can update the cart accordingly. However, before the update of the new book quantities can take place, the system first checks whether there are enough books in stock for matching the new requests. If sufficient books are not available, the system will notify the user by displaying an alert message. The user will be asked to change the contents of the cart in order to proceed further. 

If the user clicks on “Checkout”, the following sequence of windows will appear:

(see **Figure 6:** Customer Registration screen)

Because the customer was not registered, she needs to do it now in order to proceed with the purchase. When registering with [3-B.com](http://3-b.com/), the customer needs to provide a username and a password (or PIN) along with other information addition information (see Figure 6). If the provided username already exists in the database, the system will ask the customer to provide an alternative username. The customer data will be indexed according to their usernames. The password can be anything that the customer provides. The customer’s username and password will be required on subsequent access to the [3-B.com](http://3-b.com/).

If the customer decides not to register, she will not be able to proceed with the payment and the screen in Figure 7 will pop up. By clicking “OK” in this screen the system will bring up the Search screen (Figure 2). The system will not clear the shopping cart.

(see **Figure 7:** Message informing the user why they need to register to the system)

After successfully registering to the system, the user will see the following payment screen:

(see **Figure 8:** Confirm Order screen)

If the user provides a new credit card number, this number will be stored in the database. By clicking on the “Cancel” button, the system will return to the Search screen (Figure 2), but the shopping cart will not be cleared. If this is the first time that the customer is making a purchase at [3-B.com](http://3-b.com/), she may not have a credit card on file and will be asked to provide one. For this case study, assume that payments can only be made using credit card and the system will store only one credit card information for each registered user. Furthermore, we assume that all deliveries will always take five business days and the cost of shipping and handling will be $2.00 per book. (We will not worry about sales tax.)

If the user needs to update some of her information (e.g., provide a different address), she can do it by clicking on the “Update Customer Profile” button, which will bring the screen shown in Figure 9. The customer can only file one credit card.

(see **Figure 9:** Update Customer Profile screen)

The only information that the customer cannot update from her profile is the username because we are going to use this field to index the customer information in the database. When opening this screen, the system must display all the information that is available on file for this customer. The update will take place only if the customer clicks the “Update” button. If the customer clicks on “Cancel”, no update is made to her profile. If the credit card information is changed on this screen, the new credit card will replace the old one in the database. Once the user is done with the update, the system will return to the Confirm Order screen (Figure 8).

Once the user has provided all the necessary information in screen Confirm Order and clicked the “BUY IT!” button, the transaction ends and the system will update the inventory accordingly, generate the needed book orders to be placed by the administrator (see “Behind the Scenes” Section for further discussion on placing orders), clear the shopping cart content, and display the Proof of Purchase screen depicted in Figure 10.

Observe that in the Proof of Purchase screen, we indicate which user has purchased which book at what time. The time must be specified at the second level because we want to be able to ensure that a given user can make only one purchase at a time. The user may print the Proof of Purchase screen as a receipt for her files.

When printing the Proof of Purchase screen, the system must be able to correctly print out all purchased books, even though they are not shown in the screen. In the screen, the user can see all books that she purchased by scrolling down the window with the books.

We should observe that in a real system, when the customer clicks “BUY IT” on Confirm Purchase screen, the system should first contact the respective credit card company to authorize the customer’s payment. After receiving the authorization, the system would then confirm the purchase and proceed with the inventory updates and shipping process. However, for simplicity we do not elaborate these processes further.

(see **Figure 9:** Proof of Purchase screen)

## 3. Registering New Customer

Let’s say that the customer wants to register with [3-B.com](http://3-b.com/). The main reason for registering with our system is to allow us to provide a more personalized environment for the user whenever she comes back. For the purpose of this project, we will not provide any customizations. The registration process is to get the customer information in the database. The screen for registering a new customer is presented in Figure 6. Once the registration is completed, the system brings the customer back to the Search screen (Figure 2).

## 4. Returning Customer

If the customer has already registered with our system, she can enter it by selecting “Returning Customer” from the Welcome screen (Figure 1). This will bring up the User Login screen, as shown in Figure 11. Once the customer logs in, the system brings the customer back to the Search screen (Figure 2).

(see **Figure 11:** User Login screen)

Note that in both these cases, the system should not ask the user to reregister during checkout. The customer information must have been retrieved from the database while registering or logging in.

## 5. Administrator

The administrator will be responsible for generating reports periodically through the application interface. (You may assume that the administrator has database access and thereby updates book, author, publisher, review, and other information directly within the database.) In order to log in to the system, the administrator needs to first select the “Administrator” option in the Welcome screen (Figure 1), and provide her username and PIN as depicted in Figure 11.

Once the administrator logs in to the system, the following reports are automatically generated:

- Total number of registered customers in the system at the time and date of inquiry.
- Total number of book titles available in each category, in descending order.
- Average monthly sales, in dollars, for the current year, ordered by month.
- All book titles and the number of reviews for that book.
- These reports will be displayed on a single screen. This screen will have a single button, “EXIT 3-B.com”, which will bring up the welcome screen.

## 6. Behind the Scenes

In order for the system to work smoothly, we are going to need the following tasks to be performed behind the scenes by the system:

### 6.1 Shopping Cart

Whenever a new or existing customer logs in, the system creates a new shopping cart for the customer. Each time customer selects a book to buy; it is placed in the shopping cart. Repeated searches do not affect contents of shopping cart. After user completes a buy transaction, inventory is modified according to the shopping cart contents and the shopping cart is cleared.

### 6.2 Primary keys and Indexes

Primary keys will need to be defined for each table in the database. An auto increment key may be defined for this purpose or a simple/composite key using appropriate fields of the table may be used. Each database table will have to be set up with an index for efficient data retrieval and storage. One index will be created per table, based on the most used field in the searches. Some parts of this document should give you an idea of which fields to use for this purpose.

### 6.3 General assumptions about the system

We list below a few possible simplification assumptions that one could use for designing and developing the initial prototype of 3-B.com.

- You may assume that there is an unlimited stock of books.
- There is only one administrator. The administrator cannot use his account for purchasing books in 3-B.com.
- There will only be one user (customer or administrator) at a time using the system. This should facilitate the implementation as we don’t need to consider concurrency issues, or maintaining multiple customer sessions (shopping carts) opened at the same time.
- When the customer is new and has chosen not to register to the system (Search Only), we still need to create a temporary username for this unknown customer because we need to create a shopping cart for her. When she finally registers in the system, we then update the temporary username with the correct one.
- Every book is listed only once in the catalog (no multiple editions for different years).
- A customer can file only one credit card in the system. She may update it, but she can only have one current credit card active.

.. include:: <isopub.txt>

Summary of Date's book Datebase in Depth
----------------------------------------

Tuples and Relations
~~~~~~~~~~~~~~~~~~~~

tuple or tuple value
^^^^^^^^^^^^^^^^^^^^

Definition: Let *T1, T2, ..., Tn* (*n* ≥= 0) be type names, not all
necessarily distinct. Associate with each type *Ti* a distinct attribute
name, *Ai*; each of the *n* attribute-name:type-name pairs that results
is an *attribute*. Associate with each attribute a value *vi* of type
*Ti*; each of the *n* attribute:value combinations that results is a
*component*. The set of all *n* components thus defined, *t* say, is a
*tuple value* (or just *tuple* for short) over the attributes *A1, A2,
..., An*. The value *n* is the *degree* of *t*; a tuple of degree one is
*unary*, a tuple of degree two is *binary*, a tuple of degree three is
*ternary*, ...., and more generally a tuple of degree *n* is *n-ary*.
The set of all attributes is the *heading* of *t*.

To summarize, a component is an attribute plus its value. The set of all
n components is a *tuple* or *tuple value*. The set of all *n*
attributes is the *Heading*. *n* is the *degree* of the tuple.

In TUTORIAL D a *tuple type* name is written *TUPLE {H}*, where *{H}* is
the heading. If we have, for example, two attributes [STATUS: INTEGER]
and [SUPPLIER\_NAME: NAME], then the tuple type would be written as

::

     TUPLE { STATUS INTEGER, SUPPLIER_NAME NAME }

Notice, we are putting the attribute's name first followed by its type.
This is the practice throughout. A sample tuple (tuple value) might be

::

    { 20, NAME("General Electric Corporation") }

An attribute's type does not have to be a SQL type (such as VARCHAR). In
an attribute such as [EMPLOYEE: NAME], where NAME is the type and
EMPLOYEE is the attribute name, NAME would no doubt be implemented in
our SQL database as two VARCHAR columns, first\_name and last\_name, and
NAME equality would involve comparing both first\_name and last\_name.

Atomicity
^^^^^^^^^

The value of an attribute should be atomic: it should contain only one
useful piece of information and must never require further parsing.

Selectors
^^^^^^^^^

A tuple value is returned or instantiated from a tuple *selector*
invocation:

::

    TUPLE { STATUS INTEGER, SUPPLIER_NAME NAME}            // type declaration
    TUPLE { STATUS 20, SUPPLIER_NAME NAME('Smith') }       // tuple selector instantiates the tuple

The attribute type is omitted in the selector because it can always be
inferred from the type of the expression denoting the attribute value.

A note on notation
^^^^^^^^^^^^^^^^^^

The keyword TUPLE does double duty in Tutorial D. It's used both to
declare tuple *type names* and in tuple selector invocations.

Extracting attribute values from tuples
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

In Tutorial D the syntax from extracting an attribute value from a tuple
is *attribute-name FROM tuple*. For example,

::

    TUPLE { STATUS 20, SUPPLIER_NAME NAME('Smith') } t; // selector invocation
    STATUS FROM  t;                                     // extraction of tuple attribute

The empty tuple
^^^^^^^^^^^^^^^

A tuple with an empty heading has type TUPLE {} (it has no components).
It is called the *0-tuple* to emphasize that it is of degree zero. It is
also sometimes called an *empty tuple*.

Tuple equality
^^^^^^^^^^^^^^

*Definition*: Tuples *t1* and *t2* are *equal* if and only if they have
the same attributes *A1, A2, ..., An*. That is, they both are of the
same tuple type. And for all *i (i = 1, 2, ..., n)*, the value *vi* of
*Ai* in *t1* is equal to the value in *t2*.

Relations and relation values
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

*Definition:* Let *{H}* be a tuple heading and let *t1, t2, ..., tm* be
distinct tuples with heading *{H}*. The combination, *r* say, of *{H}*
and the set of tuples *{t1, t2, ..., tm}* is a *relation value* (or just
a *relation* for short) over the attributes *A1, A2, ..., An,* where
*A1, A2, ..., An* are the attributes in *{H}*; the *heading* of *r* is
*{H}*; *r* has the same attributes (and hence the same attribute names,
and types) and the same degree as that heading does. The *body* of *r*
is the set of tuples *{ t1, t2, ...,tm}.* The value *m* is the
*cardinality* of *r.*

The relational model is so called because it deals with certain
abstractions that we can think of as "tables" but are known, formally,
as relations in mathematics.

You define a relation's type in **TUTORIAL D** as **RELATION {H}**,
where H is the heading. A *relation value* (or *relation* for short) is
its set of unique tuples. An example of the definition of a relation
type

::

    RELATION { SNO SNO, SNAME NAME, STATUS INTEGER, CITY CHAR} 

Every relation value is returned by some relation selector invocation;
for example, the relation type above might have this value.

::

    RELATION { TUPLE {SNO SNO('S1'), SNAME NAME('Smith'), STATUS 20, CITY 'London'},
               TUPLE {SNO SNO('S2'), SNAME NAME('Jones'), STATUS 15, CITY 'Miami'}, 
           ...
             }

Relations by definition never contain duplicate tuples, and tuples never
contain NULLs. Relation are by definition in first normal form (1NF)
because a tuple can have only one value for each of its attribute, which
is the definition of 1NF. Both relations and their tuples contain no
sense of ordering.

Empty relations
^^^^^^^^^^^^^^^

A relation can be empty, not containing any tuples. For every relation
type is there is exactly one empty relation (of that paricular relation
type). Thus, two empty relations will both have equivalent empty bodies,
but their Heading with be different.

TABLE\_DUM and TABLE\_DEE
^^^^^^^^^^^^^^^^^^^^^^^^^

TABLE\_DUM and TABLE\_DEE are both relations of degree 0, meaning they
have no attributes. They are of type RELATION {}. TABLE\_DUM has no
tuples. TABLE\_DEE has one tuple, the 0-tuple or empty tuple.

Relation Variables
~~~~~~~~~~~~~~~~~~

relation and relvar
^^^^^^^^^^^^^^^^^^^

A relation is shorthand for *relation value* in the same way that
integer is shorthand for *integer value*. Relvar is shorthand for
*relation variable*. A relvar is a holder for a representation of a
relation value. Relvars are analgous to variables in a strongly typed
language like, say, C++, and relations are likewise analogous to the
values of those variables at a given point in time. Relvars can be
characterised as *base relvars* or *derived relvars* also know as views.
Here is the definition of a base relvars in Tutorial D.

::

    VAR S BASE RELATION { SNO SNO, SNAME NAME, STATUS INTEGER, CITY CHAR } Key { SNO }; 

Updating of relvars is a set-at-a-time operation
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Unlike SQL, operations like INSERT, DELETE and UPDATE are, in the
relational algebra, set-level operations not tuple-level opertaions: one
relation value, say *r1,* is always entirely replaced by another
relation value, say, *r2.*

Candidate keys
^^^^^^^^^^^^^^

*Definition*: A subset of the heading of a **relvar** is a candidate key
K if it satisfies two conditions:

-  The uniqueness property: no possible value of the relvar ever has two
   tuples with the same value for K.
-  The irreducibility property: no proper subset of the the candidate
   key has this uniqueness property.

Keys are defined on relvars not relations. Keys imply certain integrity
contraints, a uniqueness constraint in particular, and integrity
contraints apply to variables not values. Key values are tuples. *which
means what????*\ <--

Given this relation, which represents marriages

::

    RELATION { SPOUSE_A NAME, SPOUSE_B NAME, DATE_OF_MARRIAGE DATE }

if we assume no polygamy and that no couples marry each other more than
once, then this relvar

::

    VAR MARRIAGE BASE RELATION { SPOUSE_A NAME, SPOUSE_B NAME, DATE_OF_MARRIAGE DATE }

would have three candidate keys:

::

    KEY {SPOUSE_A, SPOUSE_B}
    KEY {SPOUSE_A, DATE_OF_MARRIAGE}
    KEY {SPOUSE_B, DATE_OF_MARRIAGE}

So if this relvar contained a TUPLE of

::

    TUPLE { SPOUSE_A NAME("Betty Smith"), SPOUSE_B NAME("John Smith") DATE_OF_MARRIAGE DATE("09-11-1955") }

the value for the key {SPOUSE\_A, SPOUSE\_B } would be

::

    TUPLE { SPOUSE_A NAME("Betty Smith"), SPOUSE_B NAME("John Smith") }

Primary key
^^^^^^^^^^^

Any one of the candidate keys can be chosen as the **primary key**.
Usually, however, the simplest candidate key is chosen. See pp. 63-64.

Foreign keys
^^^^^^^^^^^^

*Definition*: Let *R1* and *R2* be relvars, not necessarily distinct,
and let *K* be a key for *R1*. Let *FK* be a subset of *R2* that,
possibly after some attribute renaming, involves exactly the same
attributes as *K*. Then *FK* is a *foreign key* if and only if, at all
times, every tuple in *R2* has an *FK* value that is equal to the *K*
value in some (necessarily unique) tuple in *R1* at the time in
question.

Using this example of two relvars BOOKS and BOOK\_CHAPTERS

::

    VAR BOOKS BASE RELATION { BOOK_ID ISBN, BOOK_TITLE CHAR, BOOK_PRICE FLOAT}
    KEY { BOOK_ID };

    VAR BOOK_CHAPTERS BASE RELATION { CHAPTER_ID INTEGER, CHAPTER_NUMBER INTEGER, BOOK_ID ISBN, CHAPTER_NAME CHAR }
    KEY { CHAPTER_ID }
    FOREIGN KEY { BOOK_ID} REFERENCES BOOKS;

**BOOK\_ID** in BOOK\_CHAPTERS is a foreign key. While the same BOOK\_ID
value may occur in multiple tuples of BOOK\_CHAPTERS, there is one and
only one tuple in BOOKS with that same BOOK\_ID value. The foreign key
need not have the same name in the referencing relvar as in the
referenced relvar. In Tutorial D this fact would be shown using the
RENAME operator. For example

::

    VAR BOOKS BASE RELATION { BOOK_ID ISBN, BOOK_TITLE CHAR, BOOK_PRICE FLOAT }
    KEY { BOOK_ID };
     
    VAR BOOK_CHAPTERS BASE RELATION { CHAPTER_ID INTEGER, CHAPTER_NUMBER
    INTEGER, BOOK_ISBN ISBN, CHAPTER_NAME CHAR }
    KEY { CHAPTER_ID }
    FOREIGN KEY { RENAME (BOOK_ISBN AS BOOK_ID) } REFERENCES BOOKS;

The foreign key can even reference the same relvar. That is, *R1* and
*R2* in the foreign key definition can be the same relvar. For example,

::

    VAR EMP BASE RELATION { ENO ENO, ...., MNO ENO, ...}
    KEY { ENO }
    FOREIGN KEY { RENAME ( MNO AS ENO ) } REFERENCES EMP ;

Here attribue MNO denotes the employee number of the manager of the
employee identified by ENO; thus the referencing relvar and the
referenced relvar are the same. In order for the tuple equality
comparison to be valid we rename the MNO attribute, so that it is of
same type, since an attribute's name, like ENO, is part of its type.

SQL supports certain referential actions such as CASCADE, which, though
very useful, even essential, are not strictly part of the relational
algebra.

Base relvars and virtual relvars or views
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

base relation and base relvar.
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

A base relation is a relation of some type with an initial value.

view or virtual relvar
^^^^^^^^^^^^^^^^^^^^^^

*Definition:* A *view* or *virtual relvar V* is relvar whose value at
time *t* is derived by evaluting a certain relational expression at that
time *t*. The expression is specified when *V* is defined and must
mention at least one relvar.

Virtual relvars can be used like base relvars because of *closure*. We
can define further views on top of them.

+---------------------------------------------+-------------------------------------------------------------------+
| Tutorial D                                  | SQL                                                               |
+=============================================+===================================================================+
| VAR LS VIRTUAL (S WHERE CITY = 'London');   | CREATE VIEW LS AS (SELECT S.\* FROM S WHERE S,CITY = 'London');   |
+---------------------------------------------+-------------------------------------------------------------------+

Views can have candidate keys just like base relvars. They can have
integrity constraints. We can update views (although SQL's support is
weak for this). You can discover a MySQL VIEW's underlying SELECT
statement with this command:

::

    mysql>  CREATE VIEW LS AS (SELECT S.* FROM S WHERE S,CITY = 'London');
    mysql>  SELECT LS, is_updatable, view_definition FROM INFORMATION_SCHEMA.VIEWS;

snapshot versus view
^^^^^^^^^^^^^^^^^^^^

A snapshot is not a view because it has its own separate copy of the
data.

Relvars and Predicates
~~~~~~~~~~~~~~~~~~~~~~

The heading of a relvar is meant to represent a certain predicate, a
generic statement about the real world. It is the intended
interpretation, the meaning, of the relvar, also called the *intention*.

A predicate is a truth-valued function that returns TRUE or FALSE. This
if relvar *R* has predicate *P*, then every tuple *t* in *R* at some
given time can be regarded as a certain proposition derived by invoking
*P* with the attribute values from *t* as arguments. Every proposistion
*p* obtained by substituting a tuples's values always evaluates to TRUE.

So a given relvar contains, at any given time, all and only the tuples
that represent true propositions (instantiations that return TRUE) of
the predicate.

A database should be thought of as a collection of facts or true
propositions, in which the heading of a relvar represents a description
of something going on in the real world. This intended intrepretation,
the real meaning of the relvar, is called the relvar's *Predicate*. The
Predicate can be though of as a truth-value function that when given
specific values returns TRUE or FALSE. So the heading of every relation
should have an associated Predicate that describes the relation's real
meaning. The Predicate is a function whose arguments are the names of
the attributes in the heading of the relation, and a relvar's contents,
its tuples, then become true propositions (at a given point in time).
While the tuples may change over time, the Predicate does not.

Formal Predicate Definition
^^^^^^^^^^^^^^^^^^^^^^^^^^^

*Predicate Definition:*

Every relvar *R* has an associated Predicate *P*. *P* is the *intended
interpretation* or *intension* for *R*. It does not change over time.
When the values of a tuple *p* are substitued in the revlar's predicate
*P*, the resulting proposition is always true. A relvar, at any given
time, contains *all* and *only* the tuples that represent true
propostions, true instantions of the predicate.

*Extension of a Predicate*

If *P* is the predicate of some relvar *R* whose value at some given
time is *r*, then the body of *r* constitutes the *extension* of *P* at
that time. The extension varies over time, but the intention, the
Predicate, does not.

Sample predicates
^^^^^^^^^^^^^^^^^

Types are things in the real world we can talk about; relations are true
statements about those things. Types are to relations as nouns are to
sentences. If we take, as an example, the relvar for the suppliers
relation (on pp. 11, 61 in Date's book)

::

    VAR S BASE RELATION { SNO SNO, SNAME NAME, STATUS INTEGER, CITY CHAR }
    KEY {SNO };

the Predicate would be the following sentence (recalling that the
attribute's name comes first in the declaration above, then its type) :

*SNO* is a **supplier part number** for **supplier name** *SNAME* with
**status** of *STATUS*, which means ..., and is located in *CITY*
**city**

Here is another example of the predicate for an email contacts relvar.

::

    VAR EMAIL_CONTACTS BASE RELATION { CONTACT_ID INTEGER, NAME NAME, EMAIL EMAIL, OPT_OUT BOOLEAN }
    KEY {CONTACTID};

The Predicate, the sentence describing the meaning of each attribute,
would be

*CONTACT\_ID* is the **unique identifier** of someone **named** *NAME*
whose **email address** is *EMAIL* and whose **opt status** is
*OPT\_OUT*.

The current value of EMAIL\_CONTACTS consists of all tuples that
currently satisfies this Predicate.

The principle of Orthogonality
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Database Constraints should not be easy to violate because duplicate
information, dulicate tuples or subsets of tuples which duplicate part
of a larger tuple, could result. See the `principle of orthogonal
design <#orthogonality>`__

Relational Algebra
~~~~~~~~~~~~~~~~~~

The relational algebra operators are defined on relations and not
strictly speaking on relvars, although their application to relvars is
no different. Relation operators are *generic*: they apply, in effect,
to all possible relations. They are also *read-only*. They read their
operations and return a result. INSERT, UPDATE and DELETE (and relation
assignment), while they are relational operators, aren't technically
part of the relational algebra.

Some differences between SQL and Tutorial D
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

-  When a relational algebra operations, like UNION or JOIN, requires a
   correspondence between operand attributes to be established, Tutorial
   D requires the attributes to have the same name.
-  Tutorial D sometimes needs to rename attributes to avoid naming
   clashes or mismatches. SQL usually doesn't
-  SQL requires most queries to conform to SELECT — FROM — WHERE
   template. Tutorial D has no analogous requirement.

Tutorial D RENAME operator takes one relation as input and returns a
relation identical to the input except that one of the attributes has a
different name. For example

+----------------------------+-----------------------------------------------------------+
| **Tutorial D RENAME**      | **SQL equivalent**                                        |
+============================+===========================================================+
| S RENAME (CITY AS SCITY)   | SELECT S.SNO , S.NAME, S.STATUS, S.CITY AS SCITY FROM S   |
+----------------------------+-----------------------------------------------------------+

RESTRICT
^^^^^^^^

Let *bx* be a boolean expression involving zero or more attribute names
such that all of the attributes mentioned are atrributes of the same
relation *r*. Then the *restriction* of *r* according to *bx*:

::

    r WHERE bx

is the relation with a heading the sameas that of *r* and a body
consisting of all typles of *r*\ for which *bx* evaluates to TRUE. For
example,

+--------------------------+---------------------------------------------+
| S WHERE CITY = 'Paris'   | SELECT S.\* FROM S WHERE S.CITY = 'Paris'   |
+--------------------------+---------------------------------------------+

will not contain any duplicate tuples.

PROJECT
^^^^^^^

Let relation *r* have attributex X, Y,...Z (and possibly others). Then
the *projection* of *r* on *X, Y,...., Z*:

::

    r { X, Y, ..., Z }

is a relation with (a) a heading derived from the heading of *r* by
removing all attributes not mentioned in the set *{X, Y, ..., Z}* and
(b) a body consistiting of all typles *{X x, Y y, ..., Z z}* such that a
tuple appears in *r* with *X* values *x*, *Y* values *y*, ..., and *Z*
value *z*. For example,

+----------------------------+----------------------------------------------------+
| Tutorial D                 | MySQL                                              |
+============================+====================================================+
| S { SNAME, CITY, STATUS}   | SELECT DISTINCT S.SNAME, S.CITY, S.STATUS FROM S   |
+----------------------------+----------------------------------------------------+

DISTINCT is needed in the SQL formulation to insure no duplicates
occurs. The Tutorial D forumlation can also be expressed in terms of the
attributes to be discarded. Thus

::

    S { SNAME, CITY, STATUS }

is equivalent to

::

    S { ALL BUT CITY }

PROJECT has a higher precedence than other (all?) operators, so

::

    S JOIN P { PNO, CITY }

is equivalent to

::

    S JOIN ( P { PNO, CITY } )

JOIN
^^^^

*Definition:* Let relations *r* and *s* jave attributes *X1, X2, ...,
Xm, Yq, Y2, ..., Yn, Z1, Z2, ..., Zp,* respectively; in other words, the
*Y's* (*n* of them) are the common attributes, the *X's* (*m* of them)
are the other attributes of *r*, and the *Z's* (*p* of them) are the
other attributes of *s*. We can assume without loss of generality that
none of the *X's* has the same name as any of the *Z's*, thanks to the
availability of RENAME. Now let the *X's* taken together be denoted just
*X*, and similarly for the *Y's* and the *Z's*. Then the *natural
join*\ (*join* for short) of *r* and *s*:

::

    r JOIN s

is a relation with (a) a heading that is the (set-theoretic) union of
the heading of *r* and *s* and (b) a body consisting of of the set of
all tuples *t* such that *t* is the (set -theoretic) union of a tuple
appearing in *r* and a tuple appearing in *s*. In other words the
heading is *(X, Y, Z)* and the body consists of all tuples *(X x, Y y, Z
z)* such that a tuple appears in *r* with *X* value *x* and *Y* value
*y* and a tuple appears in *s* with *Y* value *y* and *Z* value *z*.

Less formally, JOIN first locates tuples with the same values for the
shared attribues. It then concatenates, joins, the unshared attribute
values of those same tuples to produce the result.

The closest SQL equivalent to the Tutorial D expression P JOIN S would
be SELECT \* FROM P NATURAL JOIN S, though not all SQL products support
this syntax; otherwise, one would have to list all the attributes

::

    SELECT P.PNO, P.PNAME, P.COLOR, P.WIEGHT, P.CITY, S.SNO, S.SNAME, S.STATUS FROM P, S WHERE P.CITY = S.CITY;

*Intersection* and *cartesian product* are special cases of JOIN. If *m
= p = 0* (meaning there are no *X's* and not *Z's*, and *r* and *s* are
thus of the same type), then *r JOIN s* degenerates to *r INTERSECT s*.
If *n = 0*, meaning there are no *Y's* and *r* and *s* thus have no
common attributes, *r JOIN s* degenerates to *r TIMES s*.

+-------------------+-------------------------------------+-------------------------------------------------------------------------------------+
| Tutorial D JOIN   | SQL equivalent                      | SQL equivalent                                                                      |
+===================+=====================================+=====================================================================================+
| S JOIN SP         | SELECT \* FROM S NATURAL JOIN SP;   | SELECT DISTINCT P.PNO, P.NAME, P.COLOR, P.WEIGHT, P.CTY, S.SNO, S.SNAME, S.STATUS   |
|                   |                                     | FROM S,SP WHERE S.SNO = SP.SNO;                                                     |
+-------------------+-------------------------------------+-------------------------------------------------------------------------------------+

NATURAL JOIN does not require the use of DISTINCT because NATURAL JOIN
will only show one SNO column, and since { SNO, PNO } is the primary key
of SP, we know the tuples will be distinct, and for a given SNO value,
the PNO values will always differ.

SQL supports several types of join: NATURAL JOIN, JOIN, INNER JOIN, LEFT
(OUTER) JOIN, and RIGHT (OUTER) JOIN. They are explained at `SQL
JOINS <http://www.w3schools.com/Sql/sql_join.asp>`__. The MySQL JOIN
syntax is explained at `MySQL JOIN
SYNTAX <http://dev.mysql.com/doc/refman/5.1/en/join.html>`__. Here are
some sample MySQL joins queries.

SELECT \* FROM S NATURAL JOIN SP;

+-------+---------+----------+----------+-------+-------+
| SNO   | SNAME   | STATUS   | CITY     | PNO   | QTY   |
+=======+=========+==========+==========+=======+=======+
| S1    | Smith   | 20       | London   | P1    | 300   |
+-------+---------+----------+----------+-------+-------+
| S1    | Smith   | 20       | London   | P2    | 200   |
+-------+---------+----------+----------+-------+-------+
| S1    | Smith   | 20       | London   | P3    | 400   |
+-------+---------+----------+----------+-------+-------+
| S1    | Smith   | 20       | London   | P4    | 200   |
+-------+---------+----------+----------+-------+-------+
| S1    | Smith   | 20       | London   | P5    | 100   |
+-------+---------+----------+----------+-------+-------+
| S1    | Smith   | 20       | London   | P6    | 100   |
+-------+---------+----------+----------+-------+-------+
| S2    | Jones   | 10       | Paris    | P1    | 300   |
+-------+---------+----------+----------+-------+-------+
| S2    | Jones   | 10       | Paris    | P2    | 400   |
+-------+---------+----------+----------+-------+-------+
| S3    | Blake   | 30       | Paris    | P2    | 200   |
+-------+---------+----------+----------+-------+-------+
| S4    | Clark   | 20       | London   | P2    | 200   |
+-------+---------+----------+----------+-------+-------+
| S4    | Clark   | 20       | London   | P4    | 300   |
+-------+---------+----------+----------+-------+-------+
| S4    | Clark   | 20       | London   | P5    | 400   |
+-------+---------+----------+----------+-------+-------+

SELECT DISTINCT S.\* FROM S NATURAL JOIN SP;

+-------+---------+----------+----------+
| SNO   | SNAME   | STATUS   | CITY     |
+=======+=========+==========+==========+
| S1    | Smith   | 20       | London   |
+-------+---------+----------+----------+
| S2    | Jones   | 10       | Paris    |
+-------+---------+----------+----------+
| S3    | Blake   | 30       | Paris    |
+-------+---------+----------+----------+
| S4    | Clark   | 20       | London   |
+-------+---------+----------+----------+

SELECT \* FROM S LEFT JOIN SP USING(SNO);

+-------+----------+----------+----------+----------+----------+
| SNO   | SNAME    | STATUS   | CITY     | PNO      | QTY      |
+=======+==========+==========+==========+==========+==========+
| S1    | Smith    | 20       | London   | P1       | 300      |
+-------+----------+----------+----------+----------+----------+
| S1    | Smith    | 20       | London   | P2       | 200      |
+-------+----------+----------+----------+----------+----------+
| S1    | Smith    | 20       | London   | P3       | 400      |
+-------+----------+----------+----------+----------+----------+
| S1    | Smith    | 20       | London   | P4       | 200      |
+-------+----------+----------+----------+----------+----------+
| S1    | Smith    | 20       | London   | P5       | 100      |
+-------+----------+----------+----------+----------+----------+
| S1    | Smith    | 20       | London   | P6       | 100      |
+-------+----------+----------+----------+----------+----------+
| S2    | Jones    | 10       | Paris    | P1       | 300      |
+-------+----------+----------+----------+----------+----------+
| S2    | Jones    | 10       | Paris    | P2       | 400      |
+-------+----------+----------+----------+----------+----------+
| S3    | Blake    | 30       | Paris    | P2       | 200      |
+-------+----------+----------+----------+----------+----------+
| S4    | Clark    | 20       | London   | P2       | 200      |
+-------+----------+----------+----------+----------+----------+
| S4    | Clark    | 20       | London   | P4       | 300      |
+-------+----------+----------+----------+----------+----------+
| S4    | Clark    | 20       | London   | P5       | 400      |
+-------+----------+----------+----------+----------+----------+
| S5    | Admans   | 30       | Athens   | *NULL*   | *NULL*   |
+-------+----------+----------+----------+----------+----------+

SELECT DISTINCT S.\* FROM S LEFT JOIN SP USING(SNO);

+-------+----------+----------+----------+
| SNO   | SNAME    | STATUS   | CITY     |
+=======+==========+==========+==========+
| S1    | Smith    | 20       | London   |
+-------+----------+----------+----------+
| S2    | Jones    | 10       | Paris    |
+-------+----------+----------+----------+
| S3    | Blake    | 30       | Paris    |
+-------+----------+----------+----------+
| S4    | Clark    | 20       | London   |
+-------+----------+----------+----------+
| S5    | Admans   | 30       | Athens   |
+-------+----------+----------+----------+

SELECT DISTINCT S.\* FROM S LEFT JOIN SP USING(SNO) WHERE SP.SNO IS NOT
NULL;

+-------+---------+----------+----------+
| SNO   | SNAME   | STATUS   | CITY     |
+=======+=========+==========+==========+
| S1    | Smith   | 20       | London   |
+-------+---------+----------+----------+
| S2    | Jones   | 10       | Paris    |
+-------+---------+----------+----------+
| S3    | Blake   | 30       | Paris    |
+-------+---------+----------+----------+
| S4    | Clark   | 20       | London   |
+-------+---------+----------+----------+

SELECT DISTINCT S.\* FROM S LEFT JOIN SP USING(SNO);

+-------+----------+----------+----------+
| SNO   | SNAME    | STATUS   | CITY     |
+=======+==========+==========+==========+
| S1    | Smith    | 20       | London   |
+-------+----------+----------+----------+
| S2    | Jones    | 10       | Paris    |
+-------+----------+----------+----------+
| S3    | Blake    | 30       | Paris    |
+-------+----------+----------+----------+
| S4    | Clark    | 20       | London   |
+-------+----------+----------+----------+
| S5    | Admans   | 30       | Athens   |
+-------+----------+----------+----------+

 

SEMIJOIN
^^^^^^^^

Many queries that require JOIN really require an extended form of the
operator called SEMIJOIN. The *semijoin* of *r* and *s* is the join of
*r* and *s*, projected back on the attributes of *r*. So, for example, S
SEMIJOIN SP is equivalent to (S JOIN SP) { SNO, SNAME, STATUS, CITY }.
An application of SEMIJOIN would be the query "Get suppliers who supply
at least one part".

**Tutorial D SEMIJOIN**

**SQL equivalents**

S SEMIJOIN SP

SELECT DISTINCT S.\* FROM S NATURAL JOIN SP;

SELECT DISTINCT S.\* FROM S,SP WHERE S.SNO = SP.SNO;

The output would look like this.

+-------+---------+----------+----------+
| SNO   | SANME   | STATUS   | CITY     |
+=======+=========+==========+==========+
| S1    | Smith   | 20       | London   |
+-------+---------+----------+----------+
| S2    | Jones   | 10       | Paris    |
+-------+---------+----------+----------+
| S3    | Blake   | 30       | Paris    |
+-------+---------+----------+----------+
| S4    | Clark   | 20       | London   |
+-------+---------+----------+----------+

A more user-friendly spelling of SEMIJOIN is MATCHING: S MATCHING SP.
Finally, observe that if the heading of *s* is a subset of *r* (that is,
*p = 0*. See the definition of JOIN), then *r* JOIN *s* degenerates to
*r* MATCHING *s*. Likewise, if *m = 0*, *r* JOIN *s* degenerates to *s*
MATCHING *r*.

TABLE\_DEE is the identity with respect to JOIN
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The concept pf JOIN can be extended to join several relvars, which would
be written JOIN { r, s, ..., w} and means r JOIN s JOIN ... JOIN w. Thus
*r* JOIN *s* can also be written JOIN { r, s }.

The JOIN of no relations, written JOIN {}, is TABLE\_DEE. TABLE\_DEE is
of type RELATION {}; i.e., it has no attributes; and it contains one
tuple, the *0-tuple* or empty tuple. The join of any relation *r* with
TABLE\_DEE is simply *r*. As a consequence, the join of no relations is
TABLE\_DEE.

Also *r* JOIN TABLE\_DEE is the same as TABLE\_DEE JOIN *r* because the
result is simply the cartesian product.

INTERSECT
^^^^^^^^^

Interest requires the relations or relvars to be of the same type.

Tutorial D

MySQL

S { CITY } INTERSECT P { CITY }

SELECT DISTINCT S.CITY FROM S INTERSECT SELECT DISTINCT P.CITY FROM P

Note, DISTINCT is not strictly needed above. INTERSECT will remove
duplicates.

UNION
^^^^^

The types of the operands must be the same.

+-------------------------------+---------------------------------+
| S { CITY } UNION P { CITY }   | SELECT DISTINCT S.CITY FROM S   |
|                               | UNION DISTINCT                  |
|                               | SELECT DISTINCT P.CITY          |
|                               | FROM P                          |
+-------------------------------+---------------------------------+

Since the default for UNION is UNION DISTINCT, DISTINCT is not strictly
needed. As a consequence, the DISTINCTs following the two SELECTs aren't
needed (note: the default for SELECT is ALL rather than DISTINCT).

MINUS and SEMIMINUS
^^^^^^^^^^^^^^^^^^^

Definition: If *r* and *s* are of the same type, then *r* MINUS *s*
consists of all typles that appear in *r* but not in *s*.

+-------------------------------+------------------+
| Tutorial D MINUS              | SQL equivalent   |
+===============================+==================+
| S { CITY } MINUS P { CITY }   | SELECT S.CITY    |
|                               | FROM S           |
|                               | EXCEPT           |
|                               | SELECT P.CITY    |
|                               | FROM P           |
+-------------------------------+------------------+

EXCEPT is the SQL equivalent of the relational algebra MINUS operator;
however, not all SQL implementations support EXCEPT, including MySQL. An
MySQL equivalent expression using a subquery is

+-------------------------------+----------------------------------------------------------------------------+
| Tutorial D MINUS              | MySQL equivalent                                                           |
+===============================+============================================================================+
| S { CITY } MINUS P { CITY }   | SELECT S.CITY FROM S WHERE S.CITY NOT IN (SELECT DISTINCT P.CITY FROM P)   |
+-------------------------------+----------------------------------------------------------------------------+

We extract those cities from the supplier relvar that are not in the
parts relvar. MINUS can be done more efficiently in MySQL using LEFT
JOIN, as `Doing Intersect and Minus in
MySQL <http://www.bitbybit.dk/carsten/blog/?p=71>`__ explains. Using
LEFT JOIN, the MySQL analogue of MINUS would be

+----------------------------------------------------------------------------+
| MySQL equivalent of MINUS using LEFT JOIN                                  |
+============================================================================+
| SELECT DISTINCT S.\* FROM S LEFT JOIN SP USING(SNO) WHERE SP.SNO IS NULL   |
+----------------------------------------------------------------------------+

MINUS is just a special case of the more general SEMIMINUS. SEMIMINUS
does not require both operands to be of the same type. The definition of
*s* SEMIMINUS *r* is "*r* MINUS (*r* SEMIJOIN *s*)" which is the same as
"*r* MINUS (*r* MATCHING *s*)". Consider the query "Get suppliers who
supply no parts at all":

+------------------------+------------------------+
| Tutorial D SEMIMINUS   | SQL equivalent         |
+========================+========================+
| S SEMIMINUS SP         | SELECT S.\*            |
|                        | FROM S                 |
|                        | EXCEPT                 |
|                        | SELECT S.\*            |
|                        | FROM S, SP             |
|                        | WHERE S.SNO = SP.SNO   |
+------------------------+------------------------+

Again, MySQL does not support EXCEPT. The MySQL analogue for SEMIMINUS
would be

MySQL analogues for SEMIMINUS

| SELECT DISTINCT S.\* FROM S LEFT JOIN SP USING(SNO)
| WHERE SP.SNO IS NULL

| SELECT DISTINCT S.\* FROM S WHERE S.SNO NOT IN
| (SELECT DISTINCT S.SNO FROM S NATURAL JOIN SP)

Tutorial D does provide the alternative, more user-friendly syntax of
 "S NOT MATCHING SP". Thinking in terms of "NOT MATCHING" makes the
MySQL expressions above perhaps more understandable.

DIVIDE
^^^^^^

In relational algebra, the divisor is another relation S, whose heading
must be a subset of the heading of R. The division is over the common
attribute(s), and the set of values used as the actual divisor are the
values found in S.

DIVIDE is perhaps easier to first illustrate. The figure below shows a
simple example of dividing a binary relation R1 by a unary relation R2.
The division is over the shared attribute I2. The divisor is the set
{1,2,3}, these being the values found in the shared attribute in R2.
Inspecting the tuples of R1, the value 'a' occurs in tuples such that
their I2 values (that is, set of values for R1.I2) match the divisor
(the set of values in the divisor). So 'a' is included in the result,
but 'b' is not because there is no tuple with '3' as the I2 value and
'b' as the I1 value.

|an image|

*Definition*: Let *r* and *s* be such that the heading of *s* is a
subset of the heading of *r*. Then the *division* of *r* by *s*, *r*
DIVIDEDBY *s* is shorthand for the following:

::

    r { X } MINUS ( ( r { X } TIMES s) MINUS r ) { X }

where X is the set-theoretic difference between the heading of *r* and
that of *s*. Let's use a example from the part and suppliers database.
Let's apply this definition to this example.

::

    SP { SNO, PNO } DIVIDEBY P { PNO }

Using the definition, this would be re-written as

::

    SP { SNO } MINUS ( ( SP { SNO } TIMES P { PNO } ) MINUS SP { SNO, PNO } ) { SNO }

If look at these steps one-by-one, we would see the following.

SP { SNO } **TIMES** P { PNO }

SP **{ SNO, PNO }**

( SP { SNO } TIMES P { PNO } ) **MINUS** SP { SNO, PNO }

+-------+-------+
| SNO   | PNO   |
+=======+=======+
| s1    | p1    |
+-------+-------+
| s1    | p2    |
+-------+-------+
| s1    | p3    |
+-------+-------+
| s1    | p4    |
+-------+-------+
| s1    | p5    |
+-------+-------+
| s1    | p6    |
+-------+-------+
| s2    | p1    |
+-------+-------+
| s2    | p2    |
+-------+-------+
| s2    | p3    |
+-------+-------+
| s2    | p4    |
+-------+-------+
| s2    | p5    |
+-------+-------+
| s2    | p6    |
+-------+-------+
| s3    | p1    |
+-------+-------+
| s3    | p2    |
+-------+-------+
| s3    | p3    |
+-------+-------+
| s3    | p4    |
+-------+-------+
| s3    | p5    |
+-------+-------+
| s3    | p6    |
+-------+-------+
| s4    | p1    |
+-------+-------+
| s4    | p2    |
+-------+-------+
| s4    | p3    |
+-------+-------+
| s4    | p4    |
+-------+-------+
| s4    | p5    |
+-------+-------+
| s4    | p6    |
+-------+-------+

+-------+-------+
| SNO   | PNO   |
+=======+=======+
| s1    | p1    |
+-------+-------+
| s1    | p2    |
+-------+-------+
| s1    | p3    |
+-------+-------+
| s1    | p4    |
+-------+-------+
| s1    | p5    |
+-------+-------+
| s1    | p6    |
+-------+-------+
| s2    | p1    |
+-------+-------+
| s2    | p2    |
+-------+-------+
| s3    | p3    |
+-------+-------+
| s4    | p2    |
+-------+-------+
| s4    | p4    |
+-------+-------+
| s4    | p5    |
+-------+-------+

+----------------------+----------------------+
| SNO                  | PNO                  |
+======================+======================+
| [STRIKEOUT:**s1**]   | [STRIKEOUT:**p1**]   |
+----------------------+----------------------+
| [STRIKEOUT:**s1**]   | [STRIKEOUT:**p2**]   |
+----------------------+----------------------+
| [STRIKEOUT:**s1**]   | [STRIKEOUT:**p3**]   |
+----------------------+----------------------+
| [STRIKEOUT:**s1**]   | [STRIKEOUT:**p4**]   |
+----------------------+----------------------+
| [STRIKEOUT:**s1**]   | [STRIKEOUT:**p5**]   |
+----------------------+----------------------+
| [STRIKEOUT:**s1**]   | [STRIKEOUT:**p6**]   |
+----------------------+----------------------+
| [STRIKEOUT:**s2**]   | [STRIKEOUT:**p1**]   |
+----------------------+----------------------+
| [STRIKEOUT:**s2**]   | [STRIKEOUT:**p2**]   |
+----------------------+----------------------+
| [STRIKEOUT:**s2**]   | [STRIKEOUT:**p3**]   |
+----------------------+----------------------+
| s2                   | p4                   |
+----------------------+----------------------+
| s2                   | p5                   |
+----------------------+----------------------+
| s2                   | p6                   |
+----------------------+----------------------+
| s3                   | p1                   |
+----------------------+----------------------+
| [STRIKEOUT:**s3**]   | [STRIKEOUT:**p2**]   |
+----------------------+----------------------+
| s3                   | p3                   |
+----------------------+----------------------+
| s3                   | p4                   |
+----------------------+----------------------+
| s3                   | p5                   |
+----------------------+----------------------+
| s3                   | p6                   |
+----------------------+----------------------+
| s4                   | p1                   |
+----------------------+----------------------+
| [STRIKEOUT:**s4**]   | [STRIKEOUT:**p2**]   |
+----------------------+----------------------+
| s4                   | p3                   |
+----------------------+----------------------+
| [STRIKEOUT:**s4**]   | [STRIKEOUT:**p4**]   |
+----------------------+----------------------+
| [STRIKEOUT:**s4**]   | [STRIKEOUT:**p5**]   |
+----------------------+----------------------+
| s4                   | p6                   |
+----------------------+----------------------+

<==>

+-------+-------+
| SNO   | PNO   |
+=======+=======+
| s2    | p4    |
+-------+-------+
| s2    | p5    |
+-------+-------+
| s2    | p6    |
+-------+-------+
| s3    | p1    |
+-------+-------+
| s3    | p3    |
+-------+-------+
| s3    | p4    |
+-------+-------+
| s3    | p5    |
+-------+-------+
| s3    | p6    |
+-------+-------+
| s4    | p1    |
+-------+-------+
| s4    | p3    |
+-------+-------+
| s4    | p6    |
+-------+-------+

 

First, the cartesian product pairs the divisor P { PNO } — the set of
unique PNO values from P — with each unique value of SNO in the dividend
SP. Next MINUS finds potential attributes values that are in the final
result. We can see this by noting that the set of tuples whose SNO value
is 's1' have (collectively) a set of PNO values that matches the set of
PNO values in the divisor. MINUS removes these 's1'-tuples completely.
Next we project this intermediate result on SNO, which gives us.

( ( SP { SNO } TIMES P { PNO } ) MINUS SP { SNO, PNO } ) **{ SNO }**

+-------+
| SNO   |
+=======+
| s2    |
+-------+
| s3    |
+-------+
| s4    |
+-------+

 

These are the set of SNO values whose PNO values *do not* match those of
the divisor. Finally, we substract these values from SP { SNO }, which
gives us back the 's1' value in SP.

SP { SNO } **MINUS** ( ( SP { SNO } TIMES P { PNO } ) MINUS SP { SNO,
PNO } ) { SNO }

+-------+
| SNO   |
+=======+
| s1    |
+-------+

 

So we see that SP { SNO, PNO } DIVIDEBY P { PNO } is:

+-------+
| SNO   |
+=======+
| s1    |
+-------+

 

The result is loosely "supplier numbers for suppliers who supply all
parts." This can be expressed SQL as

::

    SELECT DISTINCT SPX.SNO
    FROM SP AS SPX
    WHERE NOT EXISTS
    ( SELECT P.PNO 
    FROM P 
    WHERE NOT EXITS
        ( SELECT SPY.SNO
          FROM SP AS SPY
          WHERE SPY.SNO = SPX.SNO 
          AND   SPY.PNO = P.PNO ) ) 

We claim that this query finds suppliers who supply (ship) all parts.
Notice we want suppliers who have shipped parts, i.e., those SP.SNO
values *v*, such that there does not exist even one part, one P.PNO
value, that is not found in those tuples of SP whose SP.SNO value is
*v*.

On the other hand, this query is loosely "supplier numbers for suppliers
who do not supply all parts."

::

    SELECT DISTINCT SPX.SNO
    FROM SP AS SPX
    WHERE EXISTS
    ( SELECT P.PNO 
    FROM P 
    WHERE NOT EXITS
        ( SELECT SPY.SNO
          FROM SP AS SPY
          WHERE SPY.SNO = SPX.SNO 
          AND   SPY.PNO = P.PNO ) ) 

Notice here we want suppliers who have shipped parts, i.e., those SP.SNO
values *v*, such that there does exist at least one part, one P.PNO
value, that is not found in those tuples of SP whose SP.SNO value is
*v*.

Note, any query that uses DIVIDEBY can be reformulated using relational
comparison, which has the advantage of making the query clearer. A query
using relational comparison to find "supplier numbers for suppliers who
supply all parts" would be

::

    WITH (SP RENAME ( SNO AS X ) ) AS R:
    S WHERE ( R WHERE X = SNO ) { PNO } = P { PNO };

WITH AS is explained below. How relational comparison, using WITH AS,is
more straightforward (than the SQL analogue for) DIVIDEBY is explained.

EXTEND and SUMMARIZE
^^^^^^^^^^^^^^^^^^^^

Loosely, *extend* supports computation across tuples and *summarize*
supports computation down tuples.

*Definition*: The *extension* of relation *r*, written

::

    EXTEND r ADD (exp AS X)

is a relation with a heading equal to *r* extended with the attribute
*X* and a body consisting of all tuples *t* such that *t* is a typle of
*r* extended with a value for attribute *X* that is computed by
evaluation *exp* on that tuple of *r*. *r* must not have an attribute
name *X* and *exp* must not refer to *X*.

For example, there are 454 grams to a pound. So we can extend a relation
with a weight ( in lbs. ) attribute.

+------------------------------------------+---------------------------------------------------+
| Tutorial D                               | SQL                                               |
+==========================================+===================================================+
| EXTEND P ADD { WEIGHT \* 454 AS GMWT }   | SELECT P.\*, ( P.WEIGHT \* 454 ) AS GMWT FROM P   |
+------------------------------------------+---------------------------------------------------+

ADD is not addition. It means extend the heading of the relvar with an
additional attribute, which follows AS. The value of the extended
attribute is computed by evaluating the expression before AS. Some other
examples using SQL.

::

    SELECT P.*, ( p.WEIGHT * 454 ) AS GMWT
    FROM P
    WHERE GMWT > 7000.0

Such a query can also be written closer in style to Tutorial D.

::

    SELECT TEMP.PNO, TEMPGMWT
    FROM ( SELECT P.PNO, ( P.WEIGHT * 454 ) AS GMWT FROM P ) AS TEMP
    WHERE TEMP.GMWT > 7000.0

SUMMARIZE
^^^^^^^^^

*Definition*: Let *r* and *s* be realtions such that *s* is of the same
type as some projection of *r*, and let the attributes of *s* be *A1,
A2, A3, ...*. Then the *summarization*

::

    SUMMARIZE r PER { s } ADD { summary AS X }

is a relation whose heading is equal to the heading of *s* extended with
the attribute *X*, and body consisting of all tuples *t* such that *t*
is a tuple of *s* extended with a value for attribute *X*, where *X* is
computed by evaluating *summary* over all tuples of *r* that have the
same value for attributes *A1, A2, ..., An* as tuples *t* does. *X*
cannot be an attribute of *s* and *summary* must not refer to *X*. The
cardinality of the resulting relation is equal to that of *s*, and the
degree is equal to that of *s* plus one.

As an example take

::

    SUMMARIZE SP PER ( S { SNO } ) ADD ( COUNT() AS P_COUNT)

whose result would be

+-------+------------+
| SNO   | P\_COUNT   |
+=======+============+
| S1    | 6          |
+-------+------------+
| S2    | 2          |
+-------+------------+
| S3    | 1          |
+-------+------------+
| S4    | 3          |
+-------+------------+
| S5    | 0          |
+-------+------------+

While S { SNO } is not a projection of SP, it is of the same type as the
projection SP { SNO }. The result will contain the same tuples as S {
SNO }, the set of all suppliers, plus the attribute P\_COUNT, where
P\_COUNT is the total number of suppliers in SP for that tuple's SNO
value.

SUMMARIZE thus goes down 'columns' doing *summary* per tuple value in
*s*. Notice that this analogous SQL statement

::

    SELECT SP.PNO, COUNT(*) AS P_COUNT FROM SP GROUP BY SP.SNO

will only return tuples for suppliers S1, S2, S3 and S4, so it is not
equivalent to the SUMMARIZE expression. This SQL expression is
equivalent

::

    SELECT SP.SNO, TEMP.PRODUCT_COUNT FROM S, LATERAL ( SELECT COUNT(*) AS PRODUCT_COUNT FROM SP WHERE SP.SNO = S.SNO ) AS TEMP

does not contain a row ( tuple ) for S5, since S5 is not in SP.

If *s* is a projection of *r* (not just "of the same type as" some
projection of *r*) then the expression can be simplied slightly; instead
of

::

    SUMMARIZE SP PER ( SP { SNO } ) ADD ( MAX { QTY } AS MAXQ, MIN ( QTY ) AS MINQ )

you can write

::

    SUMMARIZE SP BY ( SNO ) ADD ( MAX { QTY } AS MAXQ, MIN ( QTY ) AS MINQ )

Various types of summaries are supported in Tutorial D: COUNT, SUM, AVG,
MAX, MIN, COUNTD, SUMD, AVGD ( where "D" stands for "eliminate redundant
duplicate values before summarizing" ).

::

    SUMMARIZE SP PER ( SP { SNO } ) ADD ( MAX ( QTY ) AS MAXQ, MIN ( QTY ) AS MINQ )

In this example SUMMARIZE has no PER specification.

::

    SUMMARIZE ( S WHERE CITY = 'London' ) ADD ( COUNT ( ) AS N )

Since this summarize has no PER specification, the summarizing is done
per TABLE\_DEE, i.e., it is shorthand for

::

    SUMMARIZE ( S WHERE CITY = 'London' ) PER ( TABLE_DEE ) ADD ( COUNT ( ) AS N )

Recall TABLE\_DEE is a relation with no attributes and one tupe (the
0-tuple). TABLE\_DEE fits the definitino of SUMMARIZE because it is a
projection of the relation in question, S, on the empty set of
attributes. The output of this SUMMARIZE therefore has on attribute and
one type.

Finally, there is a difference between

::

    VAR N INTEGER;
    N := COUNT ( S WHERE CITY = 'London' );

SUMMARIZE returns a relation, but the aggregate operator above returns a
scalar. It's true that it might be thought of as "returning" one scalar
value for each tuple in the PER relation, but that scalr value is then
appended to that tuple to produce a tuple in the overall SUMMARIZE
result.

SQL does have something analogous to the BY form of SUMMARIZE, but not
the more general PER form. The SQL analog of

::

    SUMMARIZE SP BY { SNO } ADD ( SUM ( QTY ) AS TQ )

is

::

    SELECT SP.SNO, SUM ( SP.QTU ) AS TQ

Finally, here is an example of EXTEND expression that is logically
equivalent to SUMMARIZE. The summarization expression of

::

    SUMMARIZE SP PER ( S { SNO } ) ADD ( COUNT ( ) AS NP )

is equivalent to this EXTEND expression, which uses the WITH AS operator
introduced next.

::

    WITH ( SP RENAME ( SNO AS X ) AS R :
    EXTEND ( S { SNO } ) ADD ( COUNT ( R WHERE X = SNO ) AS NP )

WITH AS
^^^^^^^

On p. 104 the Tutorial D **WITH AS** operator's use is illustrated to
"get suppliers who supply all parts."

::

    WITH (SP RENAME ( SNO AS X ) ) AS R:
    S WHERE ( R WHERE X = SNO ) { PNO } = P { PNO };

This is a restriction, S WHERE *exp1* = *exp2*, where *exp1* is, ( R
WHERE X = SNO ) { PNO } and *exp2* is, P { PNO }. We examine each
supplier, say, Sx in relvar S, comparing Sx's associated SNO value to
the SNO values in SP. That is the meaning of

::

    ( R WHERE X = SNO )

For example, for the tuple in S with SNO value of 'S1', after doing

::

    ( R WHERE X = SNO )

the resulting set of PNO values from SP corresponding to the 'S1' value
from S would be: { P1, P2, P3, P4, P5, P6 }. Next we project this result
on PNO, which yields the same set of values, the set of unique part
numbers supplied by 'S1'. Next we compare this result to P { PNO }, the
set of all unique part numbers.

::

    ( R WHERE X = SNO ) { PNO } = P { PNO }

Continuing the example using 'S1', the expression ( R WHERE X = SNO ) {
PNO } = P { PNO } would evaluate to TRUE. So the tuple of S containing
the SNO value of 'S1' would be in the final result. Thus, the resulting
relation will be those tuples of S that represent suppliers who supply
(have shipped parts to customers) all parts. In the sample database
there is only one such suppliers. Thus, the result is

::

    RELATION { TUPLE { SNO SNO('S1'), SNAME NAME('Smith'), STATUS 20, CITY 'London' } } 

So the forgoing query found "suppliers who supply all parts". And it is
simplier than the earlier DIVIDEBY query, which was actually a
relational formulation of the query, "Get supplier numbers for supplier
who *supply at least one part and in fact* supply all parts."

Here is another example a query using WITH AS that answers: "Get paris
of supplier numbers, *Sx* and *Sy* say, such that *Sx* and *Sy* supply
exactly the same set of parts."

::

    WITH ( S RENAME ( SNO AS SX ) { SX } AS RX,
    ( S RENAME ( SNO AS SY ) { SY } AS RY :
    ( RX JOIN RY ) WHERE ( SP WHERE SNO = SX ) { PNO } = ( SP WHERE SNO = SY ) { PNO }

Again, this is a restriction of the result of a JOIN: the outermost
operation is ( RX JOIN RY ) WHERE *exp1* = *expr2*.

Appending "SX < SY" to the WHERE clause here would produce a slightly
tidier result: it would eliminate pairs of the form (Sx, Sx) and ensure
that the pairs (Sx, Sy) and (Sy, Sx) don't appear (since JOIN is
effectively the cartesian product).

Expression Transformation
^^^^^^^^^^^^^^^^^^^^^^^^^

Distributive, associate and commutative laws apply to various operations
as mentioned on pp. 100-101. This allows an optimizer to rewrite queries
in such a way the performance is optimal.

INSERT, DELETE and UPDATE
^^^^^^^^^^^^^^^^^^^^^^^^^

Strictly speaking relational algreba has no updateing (assignment) or
comparison operators and no notion relvars. Operations like UPDATE,
INSERT and DELETE are shorthand for algebraic assigment operations. For
example, given

::

    VAR PQ BASE RELATION { PNO PNO, QTY QTY } KEY { PNO };

Inserting into PQ

::

    INSERT PQ ( SUMMARIZE SP PER ( P { PNO } ) ADD ( SUM ( QTY ) AS QTY ) );

is equivalent to the longhand assigment of:

::

    PQ := PQ UNION ( SUMMARIZE SP PER ( P { PNO } ) ADD ( SUM ( QTY ) AS QTY ) );

A DELETE of

::

    DELETE S WHERE CITY = 'Athens';

is equivalent to

::

    S := S WHERE NOT CITY = 'Athens';

and an UPDATE of

::

    UPDATE P WHERE CITY = 'London' ( WEIGHT := 2 * WEIGHT, CITY := 'Oslo' );

has the longhand equivalent:

::

    P := WITH ( P WHERE CITY = 'London' ) AS R1,
       ( EXTEND R1 ADD ( 2 * WEIGHT AS NEW_WEIGHT, 'Oslo' AS NEW_CITY ) ) AS R2,
       R2 { ALL BUT WEIGHT, CITY } AS R3,
       R3 RENAME { NEW_WEIGHT AS WEIGHT, NEW_CITY AS CITY } AS R4,
       P MINUS R1 AS R5 :
       R5 UNION R4;

First, R1 is the set of tuples to be updated, extended with the new
weight and new city as R2. Then we throw away from R2 everything but the
weight and the city. This is R3. Then we rename the new weight and city
with the proper attribute names of WEIGHT and CITY. This is R4. Then we
identify those tuples not to be updated (but to be retained). This is
R5. Finally, the result is the union of R5 and R4.

The basic SQL conceptual algorithm
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

A SQL expression can be thought of as being implemented (at least
conceptually) in three steps.

#. The FROM clause ...
#. Next, the WHERE clause ...

.. todo:: To be done later...(See Simple SQL).

Examples
^^^^^^^^

These are examples of Tutorial D and SQL analogues of various queries

Get supplier numbers for suppliers who supply part P1.

+--------------------------------------+------------------------------------------------------------+
| (SP WHERE SNO = PNO('P1')) { SNO }   | SELECT DISTINCT SP.SNO FROM SP WHERE SP.PNO = PNO('P1');   |
+--------------------------------------+------------------------------------------------------------+

Get suppliers with status in the range 15 to 25 inclusive.

+---------------------------------------+-----------------------------------------------------------------------+
| S WHERE STATUS ≥ 15 AND STATUS ≤ 25   | SELECT DISTINCT S.STATUS FROM S WHERE S.STATUS ≥ 15 AND STATUS ≤ 25   |
+---------------------------------------+-----------------------------------------------------------------------+

Get part numbers for parts supplied by a supplier in London.

+-----------------------------------------------------+-------------------------------------+
| (SP MATCHING ( S WHERE CITY = 'London' )) { PNO }   | SELECT DISTINCT SP.PNO FROM SP, S   |
|                                                     | WHERE S.CITY = CITY('London')       |
|                                                     | AND                                 |
|                                                     | SP.PNO = S.PNO;                     |
+-----------------------------------------------------+-------------------------------------+

Comments: SP MATCHING ( S WHERE CITY = 'London' ) is SP JOIN S, with the
result project back onto the attributes of SP. Since we only want PNO,
JOIN would have worked just as well.

Get part numbers for parts not supplied by any supplier in London.

+---------------------------------------------------------+-----------------------------------------------+
| (SP NOT MATCHING ( S WHERE CITY = 'London' )) { PNO }   | SELECT P.PNO FROM P                           |
|                                                         | EXCEPT                                        |
|                                                         | SELECT SP.PNO                                 |
|                                                         | FROM SP, S                                    |
|                                                         | WHERE SP.SNO = S.SNO AND S.CITY = 'London';   |
+---------------------------------------------------------+-----------------------------------------------+

Comments: NOT MATCHING is equivalent to SP SEMIMINUS (SP MATCHING (S
WHERE CITY = 'London')), which is SP MINUS (SP MATCHING S). This query
could also be expresse, if Tutorial D supports "not equal", as SP
MATCHING (S WHERE CITY NOT = CITY('London').

Get city names for suppliers in which at least two two suppliers are
located.

+--------------------------------------------------------------+--------------------------------------------------------------------------+
| (SUMMARIZE S BY CITY ADD (COUNT() AS CNUM)) WHERE CNUM > 1   | SELECT TEMP.CITY                                                         |
|                                                              | FROM (SELECT S.CITY, COUNT(\*) AS CNUM FROM S GROUP BY S.CITY) AS TEMP   |
|                                                              | WHERE TEMP.CNUM > 1                                                      |
+--------------------------------------------------------------+--------------------------------------------------------------------------+

Comment: For the Tutorial D, we do a restrict on the result of
summarize. For the SQL analogue, we also do COUNT(\*) per city. GROUP BY
specifies how the count should be done; withtout it, we would simply get
a total count of cities in each row of the result.

Get all pairs of part numbers such that some supplier supplies both of
the indicated parts.

+--------------------------------------------------------------------------+
| WITH SP { SNO, PNO } AS Z:                                               |
| ( (Z RENAME (PNO AS X))                                                  |
|      JOIN                                                                |
|   (Z RENAME (PNO AS Y)) ) { X, Y }                                       |
| SELECT XX.PNO AS X, YY.PNO AS Y                                          |
| FROM SP AS XX, SP AS YY                                                  |
| WHERE XX.SNO = YY.SNO;                                                   |
+--------------------------------------------------------------------------+

Comments: From looking at relation SP it is clear that supplier S1
supplies every part listed in P; consequently, for any pairing of part
numbers (Px, Py) there will always exist a supplier, namely S1, who
supplies both part numbers. Now how does the query ensure this? The SQL
query select pairs of part numbers, PNO, such that their suppliers are
the same, XX.SNO = YY.SNO, i.e., these parts are both supplied by the
same supplier. Note, DISTINCT is not needed because distinct values X
and Y are being returned.

In the Tutorial D query, we, in essence, join two copies of SP, SP1 JOIN
SP2, where the PNO attribute has been renamed in each copy, so that the
join occurs on SNO, the only remaining common attribute. The other two
"PNO" columns are both included, as X and Y, giving pairs of part
numbers (Px, Py) such that they share a common supplier value, a common
SNO value. So for, say the SNO value of 'S2', we would have the pairs
(P1, P1), (P1, P2), (P2, P1) and (P2, P2). For 'S4' we would have the
pairs: (P2, P2), (P2, P4), (P4, P2) and (P4, P4). For SNO value of 'S1',
we would have all possible combinations of P1 through P6. Finally, we
take the join result and project it onto { X, Y }. This eliminates
duplicate tuples, duplicate pairs.

Get the total number of parts supplied by supplier S1.

+-----------------------------------------------------+---------------------------------------------------------------------------+
| WITH (SP WHERE SNO = SNO('S1')) AS R:               | SELECT SP.SNO, TEMP.TOTAL FROM SP, LATERAL                                |
| SUMMARIZE SP PER R { SNO } ADD (COUNT() AS TOTAL)   |    (SELECT COUNT(\*) AS TOTAL FROM SP WHERE SP.SNO = SNO('S1')) AS TEMP   |
+-----------------------------------------------------+---------------------------------------------------------------------------+

or with the count by itselfi

+---------------------------------------------------------------+------------------------------------------------------------+
| EXTEND TABLE\_DEE ADD (COUNT(SP WHERE SNO = 'S1') AS TOTAL)   | SELECT COUNT(\*) AS TOTAL FROM SP WHERE SNO = SNO('S1');   |
+---------------------------------------------------------------+------------------------------------------------------------+

Comments: Tutorial D also allows for the later expression to be written

::

    COUNT (SP WHERE SNO = SNO('S1'))

Get supplier numbers for suppliers with a STATUS lower than that of
supplier S1.

+----------------------------------------------------------------------------------+--------------------------------------------------------------------+
| (S WHERE STATUS < STATUS FROM ( TUPLE FROM (S WHERE SNO = SNO('S1') )) { SNO }   | SELECT S.SNO FROM S WHERE STATUS < (SELECT S.STATUS FROM S WHERE   |
|                                                                                  | S.SNO = SNO('S1') ) ))                                             |
+----------------------------------------------------------------------------------+--------------------------------------------------------------------+

Comments: The Tutorial D "TUPLE FROM" operator extracts a tuple from the
restriction. Then the FROM operator extracts the STATUS attribute from
the tuple. So we restrict S to the tuples where STATUS is always less
than the STATUS of any of the tuples whose SNO value is S1.Integrity
Constraints

An integrity constraint, or just constraint, is just a formal name for
*business rules*. Contraints guarantee consistentency. They cannot
quarantee correctness, which involves insuring that every relvar's
predicate, it's fundamental meaning, has never been violated.

Type Constraints
^^^^^^^^^^^^^^^^

Type constraints are simply the set of legal values for the type. They
are checked when the type's selector is invoked. In Tutorial D a type
contraint looks like this

::

    TYPE POINT POSSREP CARTESIAN { X NUMERIC, Y NUMERIC CONSTRAINT SQRT (X ** 2, Y ** 2) ≤ 100.0 };

POSSREP here stands for "possible representation". If omitted, the
POSSREP defaults to the same name as the type. The constraint is that
points must lie within circle whose radius is 100. SQL does not support
type constraints.

THE\_Operators
^^^^^^^^^^^^^^

The THE\_operators (there is one for each component) return the
components of the type. Given this POINT

::

    POINT P(NUMERIC(5), NUMERIC(5));

THE\_X(P) returns the X component's value, and THE\_Y(P) returns the Y
component's value.

Database constraints
^^^^^^^^^^^^^^^^^^^^

Database constraints are constraints on the values that can appear in a
given database. They should be checked at the end of any statement that
assigns a value to some relvar in the database: in SQL at any INSERT or
UPDATE. Attributes have a built-in type constaint because the attribute
is always of a certain type. Together with type constraints they form
the business rules of an application. A relvar constraint that involves
just one relvar is a single-relvar constraint. In SQL database
constaints are expressed by means of CREATE ASSERTION statements. This
single-relvar constaints checks that "status values must be in the range
1 to 100 inclusive":

+----------------------------------------------------------------+---------------------------------------------------------------------------+
| Tutorial D                                                     | SQL                                                                       |
+================================================================+===========================================================================+
| CONSTRAINT C1 IS\_EMPTY (S WHERE STATUS < 1 OR STATUS > 100)   | CREATE ASSERTION C1 CHECK                                                 |
|                                                                | (NOT EXISTS (SELECT S.\* FROM S WHERE S.STATUS < 1 OR S.STATUS > 100));   |
+----------------------------------------------------------------+---------------------------------------------------------------------------+

This constraint involves just a single attribute of a single relvar. The
constraint "supplies in London must have status 20" would be written

+----------------------------------------------------------------------+---------------------------------------------------------------------------------+
| Tutorial D                                                           | SQL                                                                             |
+======================================================================+=================================================================================+
| CONSTRAINT C1 IS\_EMPTY (S WHERE CITY = 'London' AND STATUS ≠ 20);   | CREATE ASSERTION C1 CHECK                                                       |
|                                                                      | (NOT EXISTS (SELECT S.\* FROM S WHERE S.CITY = 'London' AND S.STATUS <> 20));   |
+----------------------------------------------------------------------+---------------------------------------------------------------------------------+

Although it involves two attributes, this is still a single-relvar
constraint. Here is constraint that involves two revlars, a multi-relvar
constraint: "no supplier with status less than 20 can supply part P6."

+--------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------+
| Tutorial D                                                                     | SQL                                                                                                    |
+================================================================================+========================================================================================================+
| CONSTRAINT C1 IS\_EMPTY ((S JOIN SP) WHERE STATUS < 20 AND PNO = PNO('P6'));   | CREATE ASSERTION C1 CHECK                                                                              |
|                                                                                | (NOT EXISTS (SELECT S.\* FROM S, SP WHERE S.SNO = SP.SNO AND S.STATUS < 20 AND SP.PNO = PNO('P6')));   |
+--------------------------------------------------------------------------------+--------------------------------------------------------------------------------------------------------+

All the constraints (AND'ed together) involving a relvar R is the
"relvar constraint" for R. The databse constraint for a given database
DB is the AND of all of the relvar constraints for the relvars in DB.

Constraint examples
^^^^^^^^^^^^^^^^^^^

All red parts must weight less than 50 lbs.

+---------------------------------------------------------+------------------------------------------------------------------------------------------+
| Tutorial D                                              | SQL                                                                                      |
+=========================================================+==========================================================================================+
| CONSTRAINT C1 IS\_EMPTY (P WHERE COLOR = COLOR('Red')   | CREATE ASSERTION C1 CHECK (NOT EXISTS (SELECT P.\* FROM P WHERE P.COLOR = COLOR('Red')   |
| AND WEIGHT ≥ WEIGHT(50.0));                             | AND P.WEIGHT ≤ 50));                                                                     |
+---------------------------------------------------------+------------------------------------------------------------------------------------------+

Every London supplier must supply part P2.

+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+
| Tutorial D                                            | SQL                                                                                                |
+=======================================================+====================================================================================================+
| CONSTRAINT C1 IS\_EMPTY                               | CREATE ASSERTION C1 CHECK (NOT EXISTS                                                              |
| (WITH (SP RENAME (SNO AS X)) AS R:                    | (SELECT \* FROM S WHERE S.CITY = 'London' AND NOT EXISTS (SELECT \* FROM SP WHERE SP.SNO = S.SNO   |
|  S WHERE CITY = 'London'                              |  AND SP.PNO = PNO('P2'))  );                                                                       |
|  AND                                                  |                                                                                                    |
|  TUPLE {PNO PNO('P2')} ∉ (R WHERE X = SNO) {PNO} );   |                                                                                                    |
+-------------------------------------------------------+----------------------------------------------------------------------------------------------------+

For further examples, see the answers to 6-16.

Database Design Theory
~~~~~~~~~~~~~~~~~~~~~~

The intent of DB design theory is to reduce redundancy so that the
database never is in an inconsistent state. While database design is
ultimately a subjective endeavor, there are certain formal principles to
keep in mind.

Functional Dependency
^^^^^^^^^^^^^^^^^^^^^

A functional dependency is a special type of single-relvar integrity
constraint important in database normalization. If an attribute's value
depends on the value of another attribute, it is functionaly dependent
on the other attribute. The formal definition is:

*Definition:* Let *A* and *B* be subsets of the heading of relvar *R*,
then *R* satisfies the functional dependency (*FD*) *A* → *B* (read "*B*
is functionally dependent on *A*" or "*A* functionaly determines *B*")
if (and only if), in every relation that is a legal value for *R*,
whenever two tulpes have the same value for *A*, they also have the same
value for *B*.

*A* and(or) *B* can be sets of attributes. As an example of a functional
dependency integrity constraint suppose we require that if two suppliers
are in the same city, then they must have the same status, or { CITY } →
{ STATUS }.

+-------+----------+----------+----------+
| SNO   | SNAME    | STATUS   | CITY     |
+=======+==========+==========+==========+
| S1    | Smith    | 20       | London   |
+-------+----------+----------+----------+
| S2    | Jones    | 30       | Paris    |
+-------+----------+----------+----------+
| S3    | Blake    | 30       | Paris    |
+-------+----------+----------+----------+
| S4    | Clark    | 20       | London   |
+-------+----------+----------+----------+
| S3    | Blake    | 30       | Paris    |
+-------+----------+----------+----------+
| S4    | Clark    | 20       | London   |
+-------+----------+----------+----------+
| S5    | Admans   | 30       | Athens   |
+-------+----------+----------+----------+

Table: S

 

In Tutorial D, this FD constraint can be expressed as:

::

    CONSTRAINT C1 COUNT(S { CITY }) = COUNT(S { CITY, STATUS });

That is, whenever two cities are identical, the pair <city, status> will
always identical.

A functional dependency (FD) clearly continues to remains valid if you
add attributes to *A* (to the left side of the functional dependency) or
substract them from *B* (the right side of the functional dependency).
Obviously, every relvar candidate key represents a functional dependency
constraint (from the key to the set of all the attributes of *R*, as
well as from the key to every subset of attributes). As just noted, this
functional dependency remains valid if we add elements to the key.
Adding attributes to a key creates what is called a *superkey*. A
*superkey* has the uniqueness property (as only one distinct tuple
contains the superkey) that all keys must have, but it does not have the
irreducibility property that a key must also have.

Boyce/Codd Normal Form
^^^^^^^^^^^^^^^^^^^^^^

*Definition:* Relvar *R* is in BCNF if and only if, for every
non-trivial functional dependency *A* → *B* satisfied by *R*, *A* is a
superkey for *R*.

Trivial functional dependencies are the obvious sorts of FDs, in which
the attributes on the left are a superset of the attributes on the
right, like these:

::

    { CITY } → { CITY }
    { SNO }  → { SNO }
    { CITY, STATUS } → { CITY}

The functional dependencies of a relvar in Boyce/Codd Normal Form
(besides the trivial functional dependencies) are always *from*
superkeys: a key or a set of attributes containing a key. To decompose a
relvar *R* into BCNF, we decompose it into smaller relvars with fewer
attributes. To ensure that no information is lost (which ultimatly means
the predicate remains valid), we must restrict the decomposition to
projections of *R* that when joined return the original relvar. So we
use project as the decomposition operator for achieving Boyce-Codd
NormalForm, and join as the recomposition operator.

We can decomposed RS, with its FD { CITY } → { STATUS }, into the
following two projections:

+-------+----------+----------+----------+
| SNO   | SNAME    | STATUS   | CITY     |
+=======+==========+==========+==========+
| S1    | Smith    | 20       | London   |
+-------+----------+----------+----------+
| S2    | Jones    | 30       | Paris    |
+-------+----------+----------+----------+
| S3    | Blake    | 30       | Paris    |
+-------+----------+----------+----------+
| S4    | Clark    | 20       | London   |
+-------+----------+----------+----------+
| S3    | Blake    | 30       | Paris    |
+-------+----------+----------+----------+
| S4    | Clark    | 20       | London   |
+-------+----------+----------+----------+
| S5    | Admans   | 30       | Athens   |
+-------+----------+----------+----------+

Table: RS

| 
| =>

+-------+----------+----------+
| SNO   | SNAME    | CITY     |
+=======+==========+==========+
| S1    | Smith    | London   |
+-------+----------+----------+
| S2    | Jones    | Paris    |
+-------+----------+----------+
| S3    | Blake    | Paris    |
+-------+----------+----------+
| S4    | Clark    | London   |
+-------+----------+----------+
| S3    | Blake    | Paris    |
+-------+----------+----------+
| S4    | Clark    | London   |
+-------+----------+----------+
| S5    | Admans   | Athens   |
+-------+----------+----------+

Table: SNC

+----------+----------+
| CITY     | STATUS   |
+==========+==========+
| London   | 20       |
+----------+----------+
| Paris    | 30       |
+----------+----------+
| Athens   | 30       |
+----------+----------+

Table: CS

 

SNC still has SNO as a key. Its only functional dependencies are from
its key. The FD { CITY } → { STATUS } makes CITY the candidate key for
CS. So both SNC and CS are in BCNF. We have eliminated the redundant
STATUS values from RS, and we have not lost any information: RS = SNC
JOIN CS.

As another example, suppose we started with a suppliers relvar that
included quanity:

+-------+----------+-------+-------+
| SNO   | STATUS   | PNO   | QTY   |
+=======+==========+=======+=======+
| S1    | 20       | P1    | 300   |
+-------+----------+-------+-------+
| S1    | 20       | P2    | 200   |
+-------+----------+-------+-------+
| S1    | 20       | P3    | 400   |
+-------+----------+-------+-------+
| S1    | 20       | P4    | 200   |
+-------+----------+-------+-------+
| S1    | 20       | P5    | 100   |
+-------+----------+-------+-------+
| S1    | 20       | P6    | 100   |
+-------+----------+-------+-------+
| S2    | 10       | P1    | 300   |
+-------+----------+-------+-------+
| S2    | 10       | P2    | 400   |
+-------+----------+-------+-------+
| S3    | 30       | P2    | 200   |
+-------+----------+-------+-------+
| S4    | 20       | P2    | 200   |
+-------+----------+-------+-------+
| S4    | 20       | P4    | 300   |
+-------+----------+-------+-------+
| S4    | 20       | P5    | 400   |
+-------+----------+-------+-------+

Table: STP

Its key is still { SNO, PNO }. But this new suppliers relvar satisfies a
FD of { SNO } → { STATUS }, and therefore it has duplicate STATUS
values. To eliminate these redundant status values we decompose it into
these two projections:

+-------+----------+-------+-------+
| SNO   | STATUS   | PNO   | QTY   |
+=======+==========+=======+=======+
| S1    | 20       | P1    | 300   |
+-------+----------+-------+-------+
| S1    | 20       | P2    | 200   |
+-------+----------+-------+-------+
| S1    | 20       | P3    | 400   |
+-------+----------+-------+-------+
| S1    | 20       | P4    | 200   |
+-------+----------+-------+-------+
| S1    | 20       | P5    | 100   |
+-------+----------+-------+-------+
| S1    | 20       | P6    | 100   |
+-------+----------+-------+-------+
| S2    | 10       | P1    | 300   |
+-------+----------+-------+-------+
| S2    | 10       | P2    | 400   |
+-------+----------+-------+-------+
| S3    | 30       | P2    | 200   |
+-------+----------+-------+-------+
| S4    | 20       | P2    | 200   |
+-------+----------+-------+-------+
| S4    | 20       | P4    | 300   |
+-------+----------+-------+-------+
| S4    | 20       | P5    | 400   |
+-------+----------+-------+-------+

Table: STP

| 
| =>

+-------+-------+-------+
| SNO   | PNO   | QTY   |
+=======+=======+=======+
| S1    | P1    | 300   |
+-------+-------+-------+
| S1    | P2    | 200   |
+-------+-------+-------+
| S1    | P3    | 400   |
+-------+-------+-------+
| S1    | P4    | 200   |
+-------+-------+-------+
| S1    | P5    | 100   |
+-------+-------+-------+
| S1    | P6    | 100   |
+-------+-------+-------+
| S2    | P1    | 100   |
+-------+-------+-------+
| S2    | P2    | 400   |
+-------+-------+-------+
| S3    | P2    | 200   |
+-------+-------+-------+
| S4    | P2    | 200   |
+-------+-------+-------+
| S4    | P4    | 300   |
+-------+-------+-------+
| S4    | P5    | 400   |
+-------+-------+-------+

Table: SP

+-------+----------+
| SNO   | STATUS   |
+=======+==========+
| S1    | 20       |
+-------+----------+
| S2    | 10       |
+-------+----------+
| S3    | 30       |
+-------+----------+
| S4    | 20       |
+-------+----------+

Table: SS

 

STP was not in BCNF because the FD { SNO } → { STATUS } was not from a
superkey. In relvar SS the functional dependency is now from a superkey
(in fact, a key), so SS is in BCNF, as is SP because { SNO, PNO } is the
key. The decomposition is lossless: STP = JOIN (SP, SS).

Lossles Decomposition and the Heath Theorem
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Decomposition is, as shown above, the process of taking projections of
the original relvar. We must ensure, though, that information is not
lost: the join of the resulting relvars should be the original relvar.
For example, consider this decomposition of RS which loses information:

+-------+----------+----------+----------+
| SNO   | SNAME    | STATUS   | CITY     |
+=======+==========+==========+==========+
| S1    | Smith    | 20       | London   |
+-------+----------+----------+----------+
| S2    | Jones    | 30       | Paris    |
+-------+----------+----------+----------+
| S3    | Blake    | 30       | Paris    |
+-------+----------+----------+----------+
| S4    | Clark    | 20       | London   |
+-------+----------+----------+----------+
| S3    | Blake    | 30       | Paris    |
+-------+----------+----------+----------+
| S4    | Clark    | 20       | London   |
+-------+----------+----------+----------+
| S5    | Admans   | 30       | Athens   |
+-------+----------+----------+----------+

Table: RS

| 
| =>

+-------+----------+----------+
| SNO   | SNAME    | STATUS   |
+=======+==========+==========+
| S1    | Smith    | 20       |
+-------+----------+----------+
| S2    | Jones    | 30       |
+-------+----------+----------+
| S3    | Blake    | 30       |
+-------+----------+----------+
| S4    | Clark    | 20       |
+-------+----------+----------+
| S5    | Admans   | 30       |
+-------+----------+----------+

Table: SNS

+----------+----------+
| CITY     | STATUS   |
+==========+==========+
| London   | 20       |
+----------+----------+
| Paris    | 30       |
+----------+----------+
| Athens   | 30       |
+----------+----------+

Table: CS

 

We have lost information: RS ≠ JOIN(SNS, CS). We no longer know the city
of the supplier. Is S2 located in Paris or Athens? Just like the first
example we decomposed the orginal relvar using project. What
condition(s) *must* be met in order for our projections to always be
equal to their join, ensuring our decompositions lossless.

The Heath Theorem provides a sufficient condition for lossless
decomposition. It tells us, if we meet the theorem's conditions, the
decomposition will be lossless. The theorem states:

*Heath Theorem*: If we take subsets of the heading of *R*, say, *A*,
*B*, and *C* such that their union is equal to the heading, and if *R*
satisfies the functional dependency constraint *A* → *B*, then *R* is
equal to the join of its projections on *AB* and *AC*, where *AB* is the
union of *A* and *B* and *AC* is the union of *A* and *C*.

If you think about it, this theorem is just a formal statement of
something obvious: if you decompose a relvar into two projections such
that both of the projections contain the "left side" of the functional
dependency (the *A* in *A* → *B*), and one of the projections also
contains the "right side" (the *B* in *A* → *B*) and the other also
contains the remaining attributes, those on neither side of the FD, then
join always gives you back the original relvar.

The Heath theorem gives us a sufficient condition to ensure the
decomposition is lossles. If the conditions of the Heath Theorem are
met, we know that our decomposition is lossless. It does not give a
necessary condition: it does not tell us however if other decompositions
will be lossey or lossless. What the necessary condition is for lossless
decomposition is discussed in the answers section of chapter 7.

The RS and STP decomposition examples above are both instances where
Heath's theorem tells us the decomposition will be lossless; we will not
lose information. In the case of relvar STP, for example, STP satisfies
the FD { SNO } → { STATUS }. { SNO } corresponds to *A* in the theorem,
{ STATUS } corresponds to B, and { PNO, QTY } to C. The union of A, B
and C is clearly the heading of STP. { SNO, STATUS } corresponds to AB,
the union of A and B. { SNO, PNO, QTY } corresponds to AC, the union of
A and B. Finally, we applying the theorem, we see that

::

    JOIN(STP { SNO, STATUS }, STP { SNO, PNO, QTY }) = STP;

Likewise, in the case of relvar RS, we have the FD { CITY } → { STATUS
}. { CITY } is A, { STATUS } is B, { STATUS, CITY } is AB, and { SNO,
SNAME, CITY } is AC. Again, we see that

::

    JOIN(RS { SNO, SNAME, CITY }, RS { STATUS, CITY }) = RS;

Here is another decomposition example. We have a relvar in first normal
form: all values are atomic. But we have a lot of redundancy.

+--------------------+--------------+-----------------------------+--------------+------+
| questionID         | answertype   | answer                      | answercode   | id   |
+====================+==============+=============================+==============+======+
| experience1        | radio        | Very experienced            | very         | 1    |
+--------------------+--------------+-----------------------------+--------------+------+
| experience1        | radio        | Somewhat experienced        | somewhat     | 1    |
+--------------------+--------------+-----------------------------+--------------+------+
| experience1        | radio        | Little experience           | little       | 1    |
+--------------------+--------------+-----------------------------+--------------+------+
| experience1        | radio        | No experience               | none         | 1    |
+--------------------+--------------+-----------------------------+--------------+------+
| experience2        | radio        | Very experienced            | very         | 2    |
+--------------------+--------------+-----------------------------+--------------+------+
| experience2        | radio        | Somewhat experienced        | somewhat     | 2    |
+--------------------+--------------+-----------------------------+--------------+------+
| experience2        | radio        | Little experience           | little       | 2    |
+--------------------+--------------+-----------------------------+--------------+------+
| experience2        | radio        | No experience               | none         | 2    |
+--------------------+--------------+-----------------------------+--------------+------+
| experience3        | radio        | Very experienced            | very         | 3    |
+--------------------+--------------+-----------------------------+--------------+------+
| experience3        | radio        | Somewhat experienced        | somewhat     | 3    |
+--------------------+--------------+-----------------------------+--------------+------+
| experience3        | radio        | Little experience           | little       | 3    |
+--------------------+--------------+-----------------------------+--------------+------+
| experience3        | radio        | No experience               | none         | 3    |
+--------------------+--------------+-----------------------------+--------------+------+
| easeofuse1         | radio        | Very simple to use          | vsimple      | 6    |
+--------------------+--------------+-----------------------------+--------------+------+
| easeofuse1         | radio        | Somewhat simple to use      | simple       | 6    |
+--------------------+--------------+-----------------------------+--------------+------+
| easeofuse1         | radio        | Somewhat difficult to use   | diff         | 6    |
+--------------------+--------------+-----------------------------+--------------+------+
| usefulness1        | radio        | Very useful                 | very         | 7    |
+--------------------+--------------+-----------------------------+--------------+------+
| usefulness1        | radio        | Somewhat useful             | somewhat     | 7    |
+--------------------+--------------+-----------------------------+--------------+------+
| usefulness1        | radio        | Not that useful             | little       | 7    |
+--------------------+--------------+-----------------------------+--------------+------+
| usefulness1        | radio        | Not useful at all           | none         | 7    |
+--------------------+--------------+-----------------------------+--------------+------+
| relevance1         | radio        | Very relevant               | very         | 8    |
+--------------------+--------------+-----------------------------+--------------+------+
| relevance1         | radio        | Somewhat relevant           | somewhat     | 8    |
+--------------------+--------------+-----------------------------+--------------+------+
| relevance1         | radio        | A little relevant           | little       | 8    |
+--------------------+--------------+-----------------------------+--------------+------+
| relevance1         | radio        | Not relevant at all         | none         | 8    |
+--------------------+--------------+-----------------------------+--------------+------+
| understand1        | radio        | Yes                         | yes          | 9    |
+--------------------+--------------+-----------------------------+--------------+------+
| understand1        | radio        | No                          | no           | 9    |
+--------------------+--------------+-----------------------------+--------------+------+
| recommend1         | radio        | Yes                         | yes          | 10   |
+--------------------+--------------+-----------------------------+--------------+------+
| recommend1         | radio        | No                          | no           | 10   |
+--------------------+--------------+-----------------------------+--------------+------+
| compare1           | radio        | More useful                 | more         | 11   |
+--------------------+--------------+-----------------------------+--------------+------+
| compare1           | radio        | Equally useful              | equal        | 11   |
+--------------------+--------------+-----------------------------+--------------+------+
| compare1           | radio        | Less useful                 | less         | 11   |
+--------------------+--------------+-----------------------------+--------------+------+
| review1            | textarea     | NULL                        |              | 12   |
+--------------------+--------------+-----------------------------+--------------+------+
| useremotelabs      | radio        | Yes                         | yes          | 4    |
+--------------------+--------------+-----------------------------+--------------+------+
| useremotelabs      | radio        | No                          | no           | 4    |
+--------------------+--------------+-----------------------------+--------------+------+
| whynotremotelabs   | textarea     | NULL                        |              | 5    |
+--------------------+--------------+-----------------------------+--------------+------+

We first notice that this relvar has the following functional
dependencies:

| { id } → { questionID }.
| { questionID } → { answertype }.
| { id } → { answertype }.

The last dependency is due to the transitivity of these first two
dependencies. We can normalize survey\_answers by splitting it into two
relations: survey\_questions and survey\_answers.

+--------------------+--------------+------+
| questionID         | answertype   | id   |
+====================+==============+======+
| experience1        | radio        | 1    |
+--------------------+--------------+------+
| experience2        | radio        | 2    |
+--------------------+--------------+------+
| experience3        | radio        | 3    |
+--------------------+--------------+------+
| easeofuse1         | radio        | 6    |
+--------------------+--------------+------+
| usefulness1        | radio        | 7    |
+--------------------+--------------+------+
| relevance1         | radio        | 8    |
+--------------------+--------------+------+
| understand1        | radio        | 9    |
+--------------------+--------------+------+
| recommend1         | radio        | 10   |
+--------------------+--------------+------+
| compare1           | radio        | 11   |
+--------------------+--------------+------+
| review1            | textarea     | 12   |
+--------------------+--------------+------+
| useremotelabs      | radio        | 4    |
+--------------------+--------------+------+
| whynotremotelabs   | textarea     | 5    |
+--------------------+--------------+------+

Table: survey\_questions

survey\_answers

answer

answercode

id

Very experienced

very

1

Somewhat experienced

somewhat

1

Little experience

little

1

No experience

none

1

Very experienced

very

2

Somewhat experienced

somewhat

2

Little experience

little

2

No experience

none

2

Very experienced

very

3

Somewhat experienced

somewhat

3

Little experience

little

3

No experience

none

3

Very simple to use

vsimple

6

Somewhat simple to use

simple

6

Somewhat difficult to use

diff

6

Very useful

very

7

Somewhat useful

somewhat

7

Not that useful

little

7

Not useful at all

none

7

Very relevant

very

8

Somewhat relevant

somewhat

8

A little relevant

little

8

Not relevant at all

none

8

Yes

yes

9

No

no

9

Yes

yes

10

No

no

10

More useful

more

11

Equally useful

equal

11

Less useful

less

11

NULL

NULL

12

Yes

yes

4

No

no

4

NULL

NULL

5

 

The functional dependencies for the new survery\_questions revlar are
still the same:

| { id } → { questionID }.
| { questionID } → { answertype }.
| { id } → { answertype }.

And since the candidate keys for the new survey\_questions relvar are {
questionID } and {id}, this means survery\_questions is in BCNF: all its
functional dependencies are *from* attributes that contain candidate
keys. Functional dependencies can be from sets of attributes (more than
one), but here the FDs are from sets containing only one attribute.

What about the relvar survey\_answers? First, we notice there is an
entity integrity problem with id values of 12 and 5, but we can just
delete those tuples because id is not a candidate key here. It is a
foreign key referring to the candidate key for survey\_questions. As
long as there is an existing id in survey\_questions for every id in
survey\_answers referential integrety will not be violated. So there is
no danger in deleting these two tuples.

The new survey\_answers appears to have the function dependency { answer
} → { answercode}. Boyce Codd Normal Form requires all functional
dependencies to be *from* supersets, but { answer } contains neither one
of the two candidate keys for survey\_answers, {answer, id} and
{answercode, id}, meaning our new survery\_answers is still not in BCNF.
We need to decompose this survey\_answers relvar further. Consider this
decomposition of survey\_answers into survey\_answer and
answer\_choices:

+--------------+------+
| answercode   | id   |
+==============+======+
| very         | 1    |
+--------------+------+
| somewhat     | 1    |
+--------------+------+
| little       | 1    |
+--------------+------+
| none         | 1    |
+--------------+------+
| very         | 2    |
+--------------+------+
| somewhat     | 2    |
+--------------+------+
| little       | 2    |
+--------------+------+
| none         | 2    |
+--------------+------+
| very         | 3    |
+--------------+------+
| somewhat     | 3    |
+--------------+------+
| little       | 3    |
+--------------+------+
| none         | 3    |
+--------------+------+
| vsimple      | 6    |
+--------------+------+
| simple       | 6    |
+--------------+------+
| diff         | 6    |
+--------------+------+
| very         | 7    |
+--------------+------+
| somewhat     | 7    |
+--------------+------+
| little       | 7    |
+--------------+------+
| none         | 7    |
+--------------+------+
| very         | 8    |
+--------------+------+
| somewhat     | 8    |
+--------------+------+
| little       | 8    |
+--------------+------+
| none         | 8    |
+--------------+------+
| yes          | 9    |
+--------------+------+
| no           | 9    |
+--------------+------+
| yes          | 10   |
+--------------+------+
| no           | 10   |
+--------------+------+
| more         | 11   |
+--------------+------+
| equal        | 11   |
+--------------+------+
| less         | 11   |
+--------------+------+
| yes          | 4    |
+--------------+------+
| no           | 4    |
+--------------+------+

Table: survey\_answers

+-----------------------------+--------------+
| answer                      | answercode   |
+=============================+==============+
| Very experienced            | very         |
+-----------------------------+--------------+
| Somewhat experienced        | somewhat     |
+-----------------------------+--------------+
| Little experience           | little       |
+-----------------------------+--------------+
| No experience               | none         |
+-----------------------------+--------------+
| Very simple to use          | vsimple      |
+-----------------------------+--------------+
| Somewhat simple to use      | simple       |
+-----------------------------+--------------+
| Somewhat difficult to use   | diff         |
+-----------------------------+--------------+
| Somewhat useful             | somewhat     |
+-----------------------------+--------------+
| Not that useful             | little       |
+-----------------------------+--------------+
| Not useful at all           | none         |
+-----------------------------+--------------+
| Very relevant               | very         |
+-----------------------------+--------------+
| Somewhat relevant           | somewhat     |
+-----------------------------+--------------+
| A little relevant           | little       |
+-----------------------------+--------------+
| Not relevant at all         | none         |
+-----------------------------+--------------+
| Yes                         | yes          |
+-----------------------------+--------------+
| No                          | No           |
+-----------------------------+--------------+
| More useful                 | more         |
+-----------------------------+--------------+
| Equally useful              | equal        |
+-----------------------------+--------------+
| Less useful                 | less         |
+-----------------------------+--------------+

Table: answer\_choices

 

Both relvars appear to be in BCNF. The only candidate key for
survery\_answers is its entire heading { answercode, id }. But since
survery\_answers only has trivial functional dependencies, it is in
BCNF. The only candidate key for answer\_choices is { answer }. Since
answer\_choices has the FD { answer } → { answercode}, which is a
dependency *from* a key, it also is in BCNF. But we now have a different
soft of problem. If we tried to join these two relations together on the
common foreign key answercode, we would have no idea whether id 1
corresponds to answer "Very experienced" or answer "Very relevant". We
have lost information, making this a lossy decomposition.

So we try yet again.

+-----------------------------+------+
| answer                      | id   |
+=============================+======+
| Very experienced            | 1    |
+-----------------------------+------+
| Somewhat experienced        | 1    |
+-----------------------------+------+
| Little experience           | 1    |
+-----------------------------+------+
| No experience               | 1    |
+-----------------------------+------+
| Very experienced            | 2    |
+-----------------------------+------+
| Somewhat experienced        | 2    |
+-----------------------------+------+
| Little experience           | 2    |
+-----------------------------+------+
| No experience               | 2    |
+-----------------------------+------+
| Very experienced            | 3    |
+-----------------------------+------+
| Somewhat experienced        | 3    |
+-----------------------------+------+
| Little experience           | 3    |
+-----------------------------+------+
| No experience               | 3    |
+-----------------------------+------+
| Very simple to use          | 6    |
+-----------------------------+------+
| Somewhat simple to use      | 6    |
+-----------------------------+------+
| Somewhat difficult to use   | 6    |
+-----------------------------+------+
| Very useful                 | 7    |
+-----------------------------+------+
| Somewhat useful             | 7    |
+-----------------------------+------+
| Not that useful             | 7    |
+-----------------------------+------+
| Not useful at all           | 7    |
+-----------------------------+------+
| Very relevant               | 8    |
+-----------------------------+------+
| Somewhat relevant           | 8    |
+-----------------------------+------+
| A little relevant           | 8    |
+-----------------------------+------+
| Not relevant at all         | 8    |
+-----------------------------+------+
| Yes                         | 9    |
+-----------------------------+------+
| No                          | 9    |
+-----------------------------+------+
| Yes                         | 10   |
+-----------------------------+------+
| No                          | 10   |
+-----------------------------+------+
| More useful                 | 11   |
+-----------------------------+------+
| Equally useful              | 11   |
+-----------------------------+------+
| Less useful                 | 11   |
+-----------------------------+------+
| Yes                         | 4    |
+-----------------------------+------+
| No                          | 4    |
+-----------------------------+------+

Table: survey\_answers

+-----------------------------+--------------+
| answer                      | answercode   |
+=============================+==============+
| Very experienced            | very         |
+-----------------------------+--------------+
| Somewhat experienced        | somewhat     |
+-----------------------------+--------------+
| Little experience           | little       |
+-----------------------------+--------------+
| No experience               | none         |
+-----------------------------+--------------+
| Very simple to use          | vsimple      |
+-----------------------------+--------------+
| Somewhat simple to use      | simple       |
+-----------------------------+--------------+
| Somewhat difficult to use   | diff         |
+-----------------------------+--------------+
| Somewhat useful             | somewhat     |
+-----------------------------+--------------+
| Not that useful             | little       |
+-----------------------------+--------------+
| Not useful at all           | none         |
+-----------------------------+--------------+
| Very relevant               | very         |
+-----------------------------+--------------+
| Somewhat relevant           | somewhat     |
+-----------------------------+--------------+
| A little relevant           | little       |
+-----------------------------+--------------+
| Not relevant at all         | none         |
+-----------------------------+--------------+
| Yes                         | yes          |
+-----------------------------+--------------+
| No                          | no           |
+-----------------------------+--------------+
| More useful                 | more         |
+-----------------------------+--------------+
| Equally useful              | equal        |
+-----------------------------+--------------+
| Less useful                 | less         |
+-----------------------------+--------------+

Table: answer\_choices

 

This time, not only are both relations in BCNF, but if you join them
together on answer, you get back the exact relation we had before. This
is a nonloss decomposition, and we note that this decomposition complies
with the criteria of Heath's theorem. To confirm that both the new
survey\_answers and answer\_choices are in BCNF, we see that

Join dependencies
^^^^^^^^^^^^^^^^^

A join dependency or **JD** is a set of projections on a relation which,
when joined together, returns the original relation. The formal
definition of a join dependency is:

*Definition*: Let *A*, *B*, *C*, ..., *Z* be subsets of the heading of a
relvar *R*. Then *R* satisfies the *join dependency* (JD)

::

    ∗ { A, B, ..., Z }

if and only if every relation that is a valid value for *R* is equal to
the join of its projections on *A*, *B*, *C*, ..., *Z*, or

::

    JOIN ( R { A }, R { B }, ..., R { Z } ) = R;

To say a relvar *R* can be losslessly decomposed into certain
projections on *A*, *B*, *C*, ..., *Z* is to say that it satisfies the
JD ∗ { A, B, ..., Z }. Join dependencies are just another way of
describing nonlossless decompositions of a relvar.

It also follows from the the Heath theorem that every FD is a JD. Take
the revlar RS above. It has the FD { CITY } → { STATUS }. We first
decomposed it into the relvars SNC and CS, with attributes of { SNO,
SNAME, CITY } and { CITY, STATUS }, respectively. RS has thus satisfied
the join dependency ∗ { { SNO, SNAME, CITY }, { CITY, STATUS } }.
Likewise, when survey\_answers had three attributes—{id, answer,
answercode}— it really had only one join dependency:  ∗ {{id, answer},
{answer, answer\_code}}.

The existence of FDs and multi–valued dependencies (MVDs) implies that
certain decompositions have lossless join. That is, FDs and MVDs imply
corresponding JDs. JDs, therefore, constitute a generalization of FDs
and MVDs. As such, while every FD and MVD can be stated as an equivalent
JD, there can be JDs which are not FDs or MVDs.

::

    ∗ { {id, answer}, {answer,answercode} }

This means that { id, answer } and { answer, answercode } were the only
two subsets in the original survey\_answers that could be nonlossly
decomposed into two separate relations. So, in order to satisfy
Boyce/Codd Normal Form, that's just what we did.

Fifth Normal Form
^^^^^^^^^^^^^^^^^

Superkeys always imply certain functional dependencies (from the
superkeys). Since every FD is also a JD (according to the Heath
Theorem), superkeys always imply certain join dependencies. Take our
suppliers relvar SS for example. { SNO } is a superkey (actually a key).
SS satisfies the JD of

::

    ∗ { {SNO, SNAME}, { SNO, STATUS }, { SNO, CITY } }

The definition of 5th Normal Form (5NF) is:

*Definition*: Relvar *R* is in 5NF if and only if every non-trivial join
dependency satisfied by *R* is implied by the superkeys of *R*

A trivial join dependency is a join dependency in which one of the
subsets of the heading is the entire heading. Obviously every relvar has
trivial join dependencies because a subset consisting of the entire
header of a relvar can be joined with any other subset of the relvar.
Also the same subset consisting of all the attributes of the header can
be joined with TABLE\_DEE.

Most relvars that are in BCNF are also in 5NF. The exceptions are small.
The following theorem explains that the only time when a BCNF relvar
could possibly not be in 5NF, could possibly have a nontrivial JD that
does not consist entirely of superkeys, is when there are keys with more
than one attribute.

*Theorem*: Let *R* be a relvar in BCNF (or even just a 3NF relvar) and
let *R* have no composite keys (that is, keys consisting of two or more
attributes), then *R* is in 5NF.

So if you can get to BCNF (which is easy enough) and there aren't any
composite keys in your BCNF relvar, you don't have to worry about the
complexities of general JDs and 5NF: you know without have to think
about the matter any further that the relvar is simply in 5NF.

What does 5NF mean?
^^^^^^^^^^^^^^^^^^^

If a relvar is in 5NF, the only nontrivial JDs are those implied by
superkeys. The only lossless projection decompostions are ones in which
every projection is on the attributes of some superkeys; each such
projection includes some key of *R*. As a consequence, the corresponding
"recomposition" joins are all **one-to-one (from one tuple to one
tuple)**, and no redunancies are or can be eliminated by the
decompostions ("joins are all one-to-one" means: "the recomposition join
is a `bijection <http://mathworld.wolfram.com/Bijection.html>`__. In
other words A JOIN B means A and B have some superkey in common (not
necessarily just one attribute) and each tuple in A corresponds to
exactly one tuple in B and vice versa." See `Dbforums
reply <f=%22http://tinyurl.com/ll8f3d%22>`__:)

5NF does not necessarily mean that all possible redundancy has been
eliminated, however. It says that further nonloss decomposition of a 5NF
relvar *R* into projections, while it might be possible, won't eliminate
any redundancies. But this does not mean that *R* is redundancy free.
Certain types of redundancies cannot be reduced through projections.
Consider the following 5NF relvar SPJ which suffers from redundancy. Its
predicate is: Supplier SNO supplies part PNO to project JNO in quanity
QTY. The sole key is { SNO, PNO, JNO }.

+-------+-------+-------+-------+
| SNO   | PNO   | JNO   | QTY   |
+=======+=======+=======+=======+
| S1    | P1    | J1    | 200   |
+-------+-------+-------+-------+
| S1    | P3    | J4    | 700   |
+-------+-------+-------+-------+
| S2    | P3    | J1    | 400   |
+-------+-------+-------+-------+
| S2    | P3    | J2    | 200   |
+-------+-------+-------+-------+
| S2    | P3    | J3    | 200   |
+-------+-------+-------+-------+
| S2    | P3    | J4    | 500   |
+-------+-------+-------+-------+
| S2    | P3    | J5    | 600   |
+-------+-------+-------+-------+
| S2    | P3    | J6    | 400   |
+-------+-------+-------+-------+
| S2    | P3    | J7    | 800   |
+-------+-------+-------+-------+
| S2    | P5    | J1    | 100   |
+-------+-------+-------+-------+

Table: SPJ

We see the fact that supplier S2 supplies part P3 repeated several
times. There are other another redundancies. The fact that part P3 is
supplied to project J4 (JNO stands for project number) is repeated. So
is the fact that J1 is supplied by supplier S2. The only nontrivial
functional dependency satisfied by this relvar is this functional
dependency:

::

    { SNO, PNO, JNO } → { QTY }

which is an arrow out of a superkey. In other words, QTY depends on all
three of SNO, PNO and JNO, and it can't appear in a relvar with anything
less than all three. Hence, there is no nonloss decomposition that can
remove the redundancies. The only JD the relvar satisfies is the trivial
JD ∗ { {SNO, PNO, JNO, QTY} }.

It is always possible to decompose a non-5NF. Because 5NF is the final
normal form with respect to projection as the decomposition operator, it
is sometimes called *projection/join* normal form to stress that the
point so long as we limit ourselves to projection as the decomposion
operator and join as the recomposition operator.

Finally, keep in mind to say that a revlar is in BCNF does not mean that
it is not in 5NF (though it usually is).

Join dependency means that an table, after it has been decomposed into
two or more smaller tables, must be capable of being joined again on
common keys to form the original table. Stated another way, 5NF
indicates when an entity cannot be further decomposed using projections.

If we examine survery\_questions again, which was in BCNF

+--------------------+--------------+------+
| questionID         | answertype   | id   |
+====================+==============+======+
| experience1        | radio        | 1    |
+--------------------+--------------+------+
| experience2        | radio        | 2    |
+--------------------+--------------+------+
| experience3        | radio        | 3    |
+--------------------+--------------+------+
| easeofuse1         | radio        | 6    |
+--------------------+--------------+------+
| usefulness1        | radio        | 7    |
+--------------------+--------------+------+
| relevance1         | radio        | 8    |
+--------------------+--------------+------+
| understand1        | radio        | 9    |
+--------------------+--------------+------+
| recommend1         | radio        | 10   |
+--------------------+--------------+------+
| compare1           | radio        | 11   |
+--------------------+--------------+------+
| review1            | textarea     | 12   |
+--------------------+--------------+------+
| useremotelabs      | radio        | 4    |
+--------------------+--------------+------+
| whynotremotelabs   | textarea     | 5    |
+--------------------+--------------+------+

Table: survey\_questions

we notice that it has these join dependencies:

| ∗{ {id, questionID}, {questionID,answertype} }
| ∗{ {questionID, id}, {id,answertype} }

survey\_questions could easily be further nonloss decomposed into two
separate relations—in two different ways! So why don't we need to
decompose it? Well, not only is survey\_questions already in BCNF, but
it's also in 5th Normal Form. This means that each join dependency is
satisfied by superkeys: {id, questionID} is a superkey,
{questionID,answertype} is also a superkey, and so are the two attribute
sets in the second JD.

More on the meaning of 5NF
^^^^^^^^^^^^^^^^^^^^^^^^^^

What does a JD really mean intuitively? Take this simplify version of
SPJ without the QTY attribute? The predicate for SPJ is: Supplier SNO
supplies part PNO to project JNO. The sole key is { SNO, PNO, JNO }.

+-------+-------+-------+
| SNO   | PNO   | JNO   |
+=======+=======+=======+
| S1    | P1    | J2    |
+-------+-------+-------+
| S1    | P2    | J1    |
+-------+-------+-------+
| S2    | P1    | J1    |
+-------+-------+-------+
| S1    | P1    | J1    |
+-------+-------+-------+

Table: SPJ

Let's attach a real-world meaning to SPJ. Suppose SPJ tells us that all
three of the following are true propostions:

#. Smith supplies monkey wrenches to some project (think of S1 as Smith
   and P1 as monkey wrenches).
#. Somebody supplies monkey wrenches to the Manhattan project (think of
   P1 as monkey wrenches and J1 as the Manhattan project).
#. Something is supplied to the Manhattan project by Smith (think of J1
   as the Manhattan project and S1 as Smith)

Then is the following proposition true?

4. Smith supplies monkey wrenches to the Manhattan project (S1 supplies
   P1 to project J1).

Normally, propositions 1, 2 and 3 would not imply proposition 4. We know
that Smith supplies wrenches to *some* project (say, project *z*) from
proposition 1, that some supplier (say, supplier *x*) supplies monkey
wrenches to the Manhattan project (from proposition 2), and that Smith
supplies some part (say, part *y*) to the Manhattan project—but we
cannot validly infer, just on the basis of the three propositions, that
*x* is Smith or *y* is monkey wrenches or *z* is the Manhattan project.

Here is how a join dependency helps supply the answer. SPJ satisfies the
join dependency ∗ { { SNO, PNO }, { PNO, JNO }, { SNO, JNO } }, which we
will abbreviate as ∗ { SP, PJ, SJ }. This JD tell us that SPJ satisfies
the following obvious constraint:

::

    IF <s,p> ∈ SP AND <p,j> ∈ PJ AND <s,j> ∈ SJ THEN <s,p,j> ∈ SPJ

For example, the tuples <S1, P1>, <P1, J1> and <S1, J1> appear in SP,
PJ, and SJ, respectively, therefore the tuple <S1, P1, J1> will
obviously appear in their join SPJ. If we look at it from a different
slightly different angle, we see that the tuple <s, p> appears in SP if
(and only if) there exists some value *z* such that <s, p, z> appears in
SPJ. Likewise, the tuple <p, j> appears in PJ if (and only if) there
exists some value *x* such that <x, p, j> appears in PJ, and the tuple
<s, j> appears in SJ if (and only if) <s, y, j> appears in SJ for some
*y*. So we see that the earlier constraint is logically equivalent to
this one:

::

    IF for some x, y, z   <s,p,z> ∈ SPJ AND
                          <x,p,j> ∈ SPJ AND
                          <s,y,j> ∈ SPJ
    THEN                  <s,p,j> ∈ SPJ

Given SPJ above, tuples <**S1**,\ **P1**,J2>, <S2,**P1**,\ **J1**> and
<**S1**,P2,\ **J1**> all appear in SPJ, and therefore so does
<**S1**,\ **P1**,\ **J1** >. The join dependecy ∗ { SP, PJ, SJ } tells
us that, given propositions 1, 2 and 3, proposition 4 is also true. We
can validly infer proposition 4 from propositions 1, 2, and 3.

This constraint has a cyclic nature (IF *s* is connect to *p* and *p* is
connected to *j* and *j* is connected back to *s* again, THEN *s* and
*p* and *j* must all be directly connected, in the sense that they must
all appear together in the same tuple). Such cyclic constraints are
instances when we might have a relvar that is in BCNF but not in 5NF.
Such cyclic constraints are, though, quite rare in practice.

Order of Normalization
^^^^^^^^^^^^^^^^^^^^^^

Well, unless we get a data set into First Normal Form, we aren't dealing
with relations at all—so it must go first. And if a relation is in 5th
Normal Form, it's also in BCNF, so theoretically we could try to skip
BCNF altogether. However, generally it's much easier to deal with
functional dependencies than join dependencies (can you imagine figuring
out all JDs for the original survey\_answers?), so going for Boyce/Codd
Normal Form is the natural progression.

And once relations are in BCNF, most of the time they will also be in
5th Normal Form—in fact, if a BCNF relation has a primary key which
contains only one attribute, you can bet on it. But still, it's good to
use 5th Normal Form as a final check.

Normalization and Common sense
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Normalization theory formalizes, explicitly describes, what are certain
commonsense principles of design.

Normalization and Dependency Preservation
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The objective of reducing redundancy can conflict with the objective of
dependency preservation. Consider the following relvar:

::

    ADDR { STREET, CITY, STATE, ZIP }

Assume ADDR has these FDs:

::

    { STREET, CITY, STATE } → { CITY }
    { ZIP } → { CITY, STATE }

Since ZIP is not a key ADDR is not in BNCF. If we apply Heath's theorem
and decompose it into BCNF projections:

::

    ZCS { ZIP, CITY, STATE }
        KEY { ZIP }

    ZS  { ZIP, STREET }
        KEY { ZIP, STREET }

The original FD of { STREET, CITY, STATE } → { CITY } is gone. It is
satisfied by the join of ZCS and ZS, but not by either of those
projections. As a result, ZCS and CS cannot be independently updated.
For example, if ZCS and CS have these values:

+---------+------------+---------+
| ZIP     | CITY       | STATE   |
+=========+============+=========+
| 10003   | New York   | NY      |
+---------+------------+---------+
| 10111   | New York   | NY      |
+---------+------------+---------+

Table: ZCS

+---------+------------+
| ZIP     | STREET     |
+=========+============+
| 10003   | Broadway   |
+---------+------------+

Table: CS

 

If we attempt to insert the tuple <10111, Broadway> into ZS, we will
violate the "missing" FD, which says there can only be on zip code for
any given street in the same city and state. However, this fact can't be
determined without examining projection ZCS as well as projection ZS.
For precisely this kind of reason, the dependency preservation objective
says: *don't split dependencies acrosss projections*.

A FD is a single relvar constraint. When a FD is eliminated during
decomposition, it changes to become a multi-relvar constraint. The
dependency preservation principle is revelant when you need the
restraint to remain a single-relvar restraint.

Orthogonality
^^^^^^^^^^^^^

Normalization is intended to reduce redundancy *within* relvars.
Orthogonality refers to avoiding redundancy *across* relvars, avoiding
duplicate tuples in two or more distinct relvars. Duplicate tuples can
occur when constraints overlap. For example, if relvar SA below consists
of suppliers who are in Paris, and relvar SB is suppliers who either
aren't in Paris or who have STATUS of 30, this overlap leads to
duplicate tuples.

+-------+---------+----------+---------+
| SNO   | SNAME   | STATUS   | CITY    |
+=======+=========+==========+=========+
| S2    | Jones   | 10       | Paris   |
+-------+---------+----------+---------+
| S3    | Blake   | 30       | Paris   |
+-------+---------+----------+---------+

Table: SA

+-------+---------+----------+----------+
| SNO   | SNAME   | STATUS   | CITY     |
+=======+=========+==========+==========+
| S1    | Jones   | 20       | London   |
+-------+---------+----------+----------+
| S3    | Blake   | 30       | Paris    |
+-------+---------+----------+----------+
| S4    | Clark   | 20       | London   |
+-------+---------+----------+----------+
| S5    | Adams   | 30       | Athens   |
+-------+---------+----------+----------+

Table: SB

 

Tuple S3 must appear in both relvars. If it didn't it would violate
their constraints. Obviously, if we never have relvars of the same type,
we will never have duplicate tuples. But we must also take into account
subsets of the attributes of a tuple. For example,

+-------+---------+----------+
| SNO   | SNAME   | STATUS   |
+=======+=========+==========+
| S1    | Smith   | 20       |
+-------+---------+----------+
| S2    | Jones   | 10       |
+-------+---------+----------+
| S3    | Blake   | 30       |
+-------+---------+----------+
| S4    | Clark   | 20       |
+-------+---------+----------+
| S5    | Adams   | 30       |
+-------+---------+----------+

Table: SX

+-------+---------+----------+
| SNO   | SNAME   | CITY     |
+=======+=========+==========+
| S1    | Smith   | London   |
+-------+---------+----------+
| S2    | Jones   | Paris    |
+-------+---------+----------+
| S3    | Blake   | Paris    |
+-------+---------+----------+
| S4    | Clark   | London   |
+-------+---------+----------+
| S5    | Adams   | Athens   |
+-------+---------+----------+

Table: SY

 

If we take just the two attributes [SNO, SNAME] from each tuple of SX
and SY, we see they are identical. This type of redundancy also leads to
update anomalies. The principle of orthogonal design can be put this
way:

*The principle of Orthogonal Design:* If *A* and *B* are distinct
relvars in the same database, then there must not exist nonlossless
decompositions of *A* and *B* into *A1*, *A2*, ... *Am* and *B1*, *B2*,
... *Bm*, respectively, such that the relvar constraints for some
projection *Ai* in the set *A1*, *A2*, ... *Am* and some projection *Bj*
in the set *B1*, *B2*, ... *Bm*, permit the same tuple to appear in
both.

That is, such decompositions "must not exist" because they introduce
redundacy across the resulting relvars. Since one "nonloss
decomposition" is the identity projection (the projection of a relvar on
all its attributes), this definition also covers the case illustrated by
the first example of SA and SB.

Like the principles of normalization, the principle of Orthogonal Design
is basically just common sense. Normalization is intended to reduce
redundancy within relvars, and the principle of orthogonality is
intended to reduce redundancy across relvars.

The example of SX and SY illustrates a lossless decomposition of S. SX
is the projection S { SNO, SNAME, STATUS}, and SY is the projection S
{SNO, SNAME, CITY }. Both SX and SY are in 5NF. Yet the decomposition is
bad because SX and SY contain duplicate tuples.

TO DO:
======

Add key points from lesson 8 and 9, having to do with PHP/SQL
implementation issues:

#. protecting against injection attacks
#. ???

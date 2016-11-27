<?php

use App\Models\Account;
use App\Models\ProjectedJournal;
use App\User;

trait CreatesModels
{
    /**
     * The Account being used for test purposes
     * @var App\Models\Account
     **/
    private $account;

    /**
     * The ProjectedJournal being used for test purposes
     * @var App\Models\ProjectedJournal
     **/
    private $projectedJournal;

    /**
     * The User with admin level permissions being used for test purposes
     * @var App\Models\User
     **/
    private $user;

    /**
     * Creates an Account model and returns it
     *
     * @param array $attributes
     * @return App\Models\Account
     **/
    public function createAccount($attributes = [])
    {
        return factory(Account::class)->create($attributes);
    }

    /**
     * Creates a Projected Journal model and returns it
     *
     * @param array $attributes
     * @return App\Models\ProjectedJournal
     **/
    public function createProjectedJournal($attributes = [])
    {
        return factory(ProjectedJournal::class)->create($attributes);
    }

    /**
     * Creates a user, logs them in and returns the user model
     *
     * @param $attributes
     * @return App\User
     **/
    public function createAndLoginUser($attributes = [])
    {
        $user = $this->getTestObject('user', $attributes);
        \Auth::login($user);

        return $user;
    }

    /**
     * Creates a pair of balanced and opposing transactions which are not reconciled
     * and returns them in an array with the 'credit' key containing to the positive
     * transaction and the 'debit' key containing the negative transaction.
     *
     * @return array
     **/
    public function createTransactionPair()
    {
        // Create account for credit transaction
        $creditAccount = $this->createAccount();

        // Create credit transaction
        $creditTransaction = $this->createTransaction([
            'account_id' => $creditAccount->id,
        ]);

        // Ensure transaction is positive by taking it's absolute value
        $creditTransaction->amount = abs($creditTransaction->amount);
        $creditTransaction->save();

        // Create account for debit transaction
        $debitAccount = $this->createAccount();

        // Create debit transaction
        $debitTransaction = $this->createTransaction([
            'account_id' => $debitAccount,
            'amount' => -$creditTransaction->amount
        ]);

        return [
            'credit' => $creditTransaction,
            'debit' => $debitTransaction
        ];
    }

    /**
     * Creates a random user and returns it
     *
     * @param array $attributes
     * @return \App\Models\User
     **/
    public function createUser($attributes = [])
    {
        return factory(App\User::class)->create($attributes);
    }

    /**
     * Returns the given attribute if it is set. If it is not set, thet set method will be returned.
     *
     * @param string $propertyName
     * @param array $attributes
     * @return mixed
     **/
    public function getTestObject($propertyName, $attributes = [])
    {
        // If the given property has not already been set
        if (is_null($this->$propertyName)) {

            // Generate new object
            $object = $this->{'create' . ucfirst($propertyName)}();

            // Set the property as the new object
            $this->setTestObject($propertyName, $object);
        }

        // If any attributes have been provided we'll set them on the object
        if (!empty($attributes)) {
            collect($attributes)->each( function($value, $key) use ($propertyName) {
                $this->$propertyName->$key = $value;
                $this->$propertyName->save();
            });
        }
        return $this->$propertyName;
    }

    /**
     * Sets the given property to the given object. If none is provided, a new one will be generated.
     *
     * @param string $propertyName
     * @param mixed $object (optional)
     **/
    public function setTestObject($propertyName, $object = null)
    {
        // If no object is provided we'll just generate a new one
        if (is_null($object)) {

            // Generate new object
            $object = $this->{'create' . ucfirst($propertyName)}($attributes);
        }

        // Set object
        $this->$propertyName = $object;
    }
}

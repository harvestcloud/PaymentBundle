<?php

/*
 * This file is part of the Harvest Cloud package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HarvestCloud\PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HarvestCloud\InvoiceBundle\Entity\Invoice;

/**
 * InvoicePaymentLineItem Entity
 *
 * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
 * @since  2013-03-24
 *
 * @ORM\Entity
 */
class InvoicePaymentLineItem extends PaymentLineItem
{
    /**
     * @ORM\ManyToOne(targetEntity="HarvestCloud\InvoiceBundle\Entity\Invoice", inversedBy="invoicePaymentLineItems", cascade={"persist"})
     * @ORM\JoinColumn(name="invoice_id", referencedColumnName="id")
     */
    protected $invoice;

    /**
     * __construct()
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2013-03-24
     *
     * @param  \HarvestCloud\Invoice\Entity\Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->setInvoice($invoice);
        $this->setAmount($invoice->getAmountDue());
    }

    /**
     * Set invoice
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2013-03-24
     *
     * @param  \HarvestCloud\InvoiceBundle\Entity\Invoice $invoice
     *
     * @return InvoicePaymentLineItem
     */
    public function setInvoice(\HarvestCloud\InvoiceBundle\Entity\Invoice $invoice = null)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get invoice
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2013-03-24
     *
     * @return \HarvestCloud\InvoiceBundle\Entity\Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * post()
     *
     * @author Tom Haskins-Vaughan <tom@harvestcloud.com>
     * @since  2013-03-24
     */
    public function post()
    {
        $this->getInvoice()->setAmountDue(
            $this->getInvoice()->getAmountDue() - $this->getAmount()
        );

        parent::post();
    }
}
